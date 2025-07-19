<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\DeviceToken;
use App\Models\Form;
use App\Models\Frontend;
use App\Models\Game;
use App\Models\GameLog;
use App\Models\NotificationLog;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function dashboard()
    {
        $games         = Game::active()->get();
        $gamesTrending = Game::where('trending', Status::ENABLE)->active()->get();
        $gamesFeatured = Game::where('featured', Status::ENABLE)->active()->get();

        $user                    = Auth::user();
        $widget['total_balance'] = $user->balance;
        $widget['name']          = $user->fullname;

        $elements  = Frontend::where('tempname', activeTemplateName())->where('data_keys', 'slider.element')->orderBy('id', 'desc')->get();
        $elements  = $elements->pluck('data_values');
        $imagePath = asset('assets/images/frontend/slider');

        $notify[] = 'User dashboard data';
        return response()->json([
            'remark'  => 'user_dashboard',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'games'              => $games,
                'gamesTrending'      => $gamesTrending,
                'gamesFeatured'      => $gamesFeatured,
                'user'               => $user,
                'widget'             => $widget,
                'image_path'         => asset(getFilePath('game')),
                'slider_image_names' => $elements,
                'slider_image_path'  => $imagePath,
                'userImage'          => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
            ],
        ]);
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            $notify[] = 'You\'ve already completed your profile';
            return responseError('already_completed', $notify);
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $validator = Validator::make($request->all(), [
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);

        if ($validator->fails()) return responseError('validation_error', $validator->errors());

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = 'No special character, space or capital letters in username';
            return responseError('validation_error', $notify);
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;

        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->state        = $request->state;
        $user->zip          = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code    = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = 'Profile completed successfully';
        return responseSuccess('profile_completed', $notify, ['user' => $user]);
    }

    public function kycForm()
    {
        $user = auth()->user();
        if ($user->kv == Status::KYC_PENDING) {
            $notify[] = 'Your KYC is under review';
            return responseError('under_review', $notify);
        }
        if ($user->kv == Status::KYC_VERIFIED) {
            $notify[] = 'You are already KYC verified';
            return responseError('already_verified', $notify);
        }
        $form     = Form::where('act', 'kyc')->first();
        $notify[] = 'KYC field is below';
        return responseSuccess('kyc_form', $notify, ['form' => $form->form_data]);
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        if (!$form) {
            $notify[] = 'Invalid KYC request';
            return responseError('invalid_request', $notify);
        }
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);

        $validator = Validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }
        $user = auth()->user();
        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $userData = $formProcessor->processFormData($request, $formData);

        $user->kyc_data             = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv                   = Status::KYC_PENDING;
        $user->save();

        $notify[] = 'KYC data submitted successfully';
        return responseSuccess('kyc_submitted', $notify, ['kyc_data' => $user->kyc_data]);
    }

    public function kycData()
    {
        $user = auth()->user();
        $kycData = $user->kyc_data ?? [];
        $kycValues = [];
        foreach ($kycData as $kycInfo) {
            if (!$kycInfo->value) {
                continue;
            }
            if ($kycInfo->type == 'checkbox') {
                $value = implode(', ', $kycInfo->value);
            } elseif ($kycInfo->type == 'file') {
                $value = encrypt(getFilePath('verify') . '/' . $kycInfo->value);
            } else {
                $value = $kycInfo->value;
            }

            $kycValues[] = [
                'name' => $kycInfo->name,
                'type' => $kycInfo->type,
                'value' => $value
            ];
        }
        $notify[] = 'KYC data';
        return responseSuccess('kyc_data', $notify, ['kyc_data' => $kycValues]);
    }

    public function depositHistory(Request $request)
    {
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        $notify[] = 'Deposit data';
        return responseSuccess('deposits', $notify, ['deposits' => $deposits]);
    }

    public function transactions(Request $request)
    {
        $remarks      = Transaction::distinct('remark')->get('remark');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $type         = $request->type == 'plus' ? '+' : '-';
            $transactions = $transactions->where('trx_type', $type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions            = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        $user                    = Auth::user();
        $widget['total_balance'] = $user->balance;
        $widget['total_invest']  = GameLog::where('user_id', $user->id)->sum('invest');
        $widget['total_win']     = GameLog::win()->where('user_id', $user->id)->sum('invest');

        $notify[] = 'Transactions data';
        return responseSuccess('transactions', $notify, [
            'transactions'  => $transactions,
            'remarks'       => $remarks,
            'total_balance' => $widget['total_balance'],
            'total_invest'  => $widget['total_invest'],
            'total_win'     => $widget['total_win'],
        ]);
    }

    public function submitProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname'  => 'required',
            'image'     => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required'  => 'The last name field is required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;

        $user->address = $request->address;
        $user->city    = $request->city;
        $user->state   = $request->state;
        $user->zip     = $request->zip;

        if ($request->hasFile('image')) {
            try {
                $old         = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();

        $notify[] = 'Profile updated successfully';
        return responseSuccess('profile_updated', $notify);
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = 'Password changed successfully';
            return responseSuccess('password_changed', $notify);
        } else {
            $notify[] = 'The password doesn\'t match!';
            return responseError('validation_error', $notify);
        }
    }

    public function gameLog()
    {
        $logs     = GameLog::where('user_id', auth()->id())->where('status', 1)->where('demo_play', Status::NO)->latest()->with('game')->get();
        $notify[] = 'Game Logs';
        return responseSuccess('game_logs', $notify, $logs);
    }

    public function demoGameLog()
    {
        $logs     = GameLog::where('user_id', auth()->id())->where('status', 1)->where('demo_play', Status::YES)->latest()->with('game')->get();
        $notify[] = 'Game Logs';
        return responseSuccess('game_logs', $notify, $logs);
    }

    public function referrals()
    {
        $user     = User::where('id', auth()->id())->with('allReferrals')->firstOrFail();
        $maxLevel = Referral::max('level');

        $notify[] = 'Referrals Info';
        return response()->json([
            'remark'  => 'referrals',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'referral_users' => $user,
                'level'          => $maxLevel,
            ],
        ]);
    }

    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            $notify[] = 'Token already exists';
            return responseError('token_exists', $notify);
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::YES;
        $deviceToken->save();

        $notify[] = 'Token saved successfully';
        return responseSuccess('token_saved', $notify);
    }

    public function show2faForm()
    {
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $notify[]  = '2FA Qr';
        return responseSuccess('2fa_qr', $notify, [
            'secret' => $secret,
            'qr_code_url' => $qrCodeUrl,
        ]);
    }

    public function create2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'code'   => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $user = auth()->user();

        $response = verifyG2fa($user, $request->code, $request->secret);
        if ($response) {

            $user->tsc = $request->secret;
            $user->ts  = Status::ENABLE;
            $user->save();

            $notify[] = 'Google authenticator activated successfully';
            return responseSuccess('2fa_qr', $notify);
        } else {
            $notify[] = 'Wrong verification code';
            return responseError('wrong_verification', $notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = Status::DISABLE;
            $user->save();
            $notify[] = 'Two factor authenticator deactivated successfully';
            return responseSuccess('2fa_qr', $notify);
        } else {
            $notify[] = 'Wrong verification code';
            return responseError('wrong_verification', $notify);
        }
    }

    public function pushNotifications()
    {
        $notifications = NotificationLog::where('user_id', auth()->id())->where('sender', 'firebase')->orderBy('id', 'desc')->paginate(getPaginate());
        $notify[]      = 'Push notifications';
        return responseSuccess('notifications', $notify, [
            'notifications' => $notifications,
        ]);
    }

    public function pushNotificationsRead($id)
    {
        $notification = NotificationLog::where('user_id', auth()->id())->where('sender', 'firebase')->find($id);
        if (!$notification) {
            $notify[] = 'Notification not found';
            return responseError('notification_not_found', $notify);
        }
        $notify[]                = 'Notification marked as read successfully';
        $notification->user_read = 1;
        $notification->save();
        return responseSuccess('notification_read', $notify);
    }

    public function userInfo()
    {
        $notify[] = 'User information';
        return responseSuccess('user_info', $notify, [
            'user' => auth()->user(),
            'userImage' => getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')),
        ]);
    }

    public function deleteAccount()
    {
        $user              = auth()->user();
        $user->username    = 'deleted_' . $user->username;
        $user->email       = 'deleted_' . $user->email;
        $user->provider_id = 'deleted_' . $user->provider_id;
        $user->save();

        $user->tokens()->delete();

        $notify[] = 'Account deleted successfully';
        return responseSuccess('account_deleted', $notify);
    }

    public function downloadAttachment($fileHash)
    {

        try {
            $filePath = decrypt($fileHash);
        } catch (\Exception $e) {
            $notify[] = 'Invalid file';
            return responseError('invalid_failed', $notify);
        }
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '-attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = 'File downloaded failed';
            return responseError('download_failed', $notify);
        }
        if (!headers_sent()) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET,');
            header('Access-Control-Allow-Headers: Content-Type');
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }
}
