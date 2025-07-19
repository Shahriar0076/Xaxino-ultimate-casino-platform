<?php

namespace App\Http\Controllers\Api;

use App\Models\Deposit;
use App\Constants\Status;
use App\Lib\FormProcessor;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Gateway\PaymentController as GatewayPaymentController;

class PaymentController extends Controller
{
    public function methods()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();
        $notify[] = 'Payment Methods';
        return responseSuccess('deposit_methods', $notify, [
            'methods' => $gatewayCurrency,
            'image_path' => getFilePath('gateway')
        ]);
    }

    public function depositInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'      => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency'    => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = 'Invalid gateway';
            return responseError('invalid_gateway', $notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = 'Please follow deposit limit';
            return responseError('invalid_amount', $notify);
        }

        $charge      = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable     = $request->amount + $charge;
        $finalAmount = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->from_api        = 1;
        $data->is_web          = @$request->is_web ? 1 : 0;
        $data->user_id         = $user->id;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $request->amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amount    = $finalAmount;
        $data->btc_amount      = 0;
        $data->btc_wallet      = "";
        $data->success_url     = $request->success_url ?? route('user.deposit.history');
        $data->failed_url      = $request->failed_url ?? route('user.deposit.history');
        $data->trx             = getTrx();
        $data->save();

        $notify[] = 'Deposit inserted';

        if ($request->is_web && $data->gateway->code < 1000) {
            $dirName = $data->gateway->alias;
            $new = 'App\\Http\\Controllers\\Gateway\\' . $dirName . '\\ProcessController';

            $gatewayData = $new::process($data);
            $gatewayData = json_decode($gatewayData);

            // for Stripe V3
            if (@$data->session) {
                $data->btc_wallet = $gatewayData->session->id;
                $data->save();
            }

            return responseSuccess('deposit_inserted', $notify, [
                'deposit' => $data,
                'gateway_data' => $gatewayData
            ]);
        }
        $data->load('gateway', 'gateway.form');

        return responseSuccess('deposit_inserted', $notify, [
            'deposit' => $data,
            'redirect_url' => route('deposit.app.confirm', encrypt($data->id))
        ]);
    }

    public function appPaymentConfirm(Request $request)
    {
        if (!gs('in_app_payment')) {
            $notify[] = 'In app purchase feature currently disable';
            return responseError('feature_disable', $notify);
        }
        $validator = Validator::make($request->all(), [
            'method_code'    => 'required|in:5001',
            'amount'         => 'required|numeric|gt:0',
            'currency'       => 'required|string',
            'purchase_token' => 'required',
            'package_name'   => 'required',
            'plan_id'        => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $user = auth()->user();

        $deposit = Deposit::where('status', Status::PAYMENT_SUCCESS)->where('btc_wallet', $request->purchase_token)->exists();
        if ($deposit) {
            $notify[] = 'Payment already captured';
            return responseError('payment_captured', $notify);
        }

        if (!file_exists(getFilePath('appPurchase') . '/google_pay.json')) {
            $notify[] = 'Configuration file missing';
            return responseError('configuration_missing', $notify);
        }
        $configuration = getFilePath('appPurchase') . '/google_pay.json';
        $client        = new \Google_Client();
        $client->setAuthConfig($configuration);
        $client->setScopes([\Google_Service_AndroidPublisher::ANDROIDPUBLISHER]);
        $service = new \Google_Service_AndroidPublisher($client);

        $packageName   = $request->package_name;
        $productId     = $request->plan_id;
        $purchaseToken = $request->purchase_token;
        try {
            $response = $service->purchases_products->get($packageName, $productId, $purchaseToken);
        } catch (\Exception $e) {
            $errorJson = json_decode($e->getMessage());
            $errorMessage = isset($errorJson->error->message) && $errorJson->error->message ? $errorJson->error->message : '';

            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = $user->id;
            $adminNotification->title     = 'In App Purchase Error: ' . $errorMessage;
            $adminNotification->click_url = '#';
            $adminNotification->save();

            $notify[] = 'Something went wrong';
            return responseError('invalid_purchase', $notify);
        }

        if ($response->getPurchaseState() != 0) {
            $notify[] = 'Invalid purchase';
            return responseError('invalid_purchase', $notify);
        }

        //the amount should be your product amount
        $amount = 10;
        $rate   = $request->amount / $amount;

        $data                  = new Deposit();
        $data->user_id         = $user->id;
        $data->method_code     = $request->method_code;
        $data->method_currency = $request->currency;
        $data->amount          = $amount;
        $data->charge          = 0;
        $data->rate            = $rate;
        $data->final_amount    = $request->amount;
        $data->btc_amount      = 0;
        $data->btc_wallet      = $request->purchase_token;
        $data->trx             = getTrx();
        $data->save();

        GatewayPaymentController::userDataUpdate($data);

        $notify[] = 'Payment confirmed successfully';
        return responseSuccess('payment_confirm', $notify);
    }

    public function manualDepositConfirm(Request $request)
    {
        $track = $request->track;
        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();

        if (!$data) {
            $notify[] = 'Invalid request';
            return responseError('invalid_request', $notify);
        }

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $data->user->id;
        $adminNotification->title     = 'Deposit request from ' . $data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amount, currencyFormat: false),
            'amount'          => showAmount($data->amount, currencyFormat: false),
            'charge'          => showAmount($data->charge, currencyFormat: false),
            'rate'            => showAmount($data->rate, currencyFormat: false),
            'trx'             => $data->trx
        ]);

        $notify[] = ['You have deposit request has been taken'];
        return responseSuccess('deposit_request_taken', $notify);
    }
}
