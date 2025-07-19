<?php

namespace App\Games;

use App\Constants\Status;
use App\Models\Game as GameModel;
use App\Models\GameLog;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

abstract class Game
{
    private $globalValidationRule = [
        'invest' => 'required|numeric|gt:0'
    ];
    protected $extraValidationRule = [];
    protected $exceptValidationRule = [];
    protected $extraEndValidationRule = [];
    protected $alias;
    protected $game;
    protected $request;
    protected $user;
    protected $resultShowOnStart = true;
    protected $extraResponseOnStart = [];
    protected $extraResponseOnEnd = [];
    protected $userSelect;
    protected $hasCustomCompleteLogic = false;
    protected $extraResponseOnWin = [];
    public $demoPlay = false;
    public $fromApi = false;

    public function __construct()
    {
        $this->request = request();
        $this->user = auth()->user();
        $this->game = GameModel::active()->where('alias', $this->alias)->first();
        $this->userSelect = @$this->request->choose;
    }

    public function play()
    {
        $user = $this->user;
        if (!$this->game) {
            if ($this->fromApi) {
                $notify[] = 'Game not found';
                return responseError('not_found', $notify);
            }
            return response()->json(['error' => 'Game not found']);
        }

        $validator = Validator::make($this->request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            if ($this->fromApi) {
                return responseError('validation_error', $validator->errors()->all());
            }
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fallback = $this->fallback();
        if (@$fallback['error']) {
            if ($this->fromApi) {
                return responseError('fallback_error', $fallback['error']);
            }
            return response()->json($fallback);
        }

        $gameResult = $this->gameResult();
        $invest = $this->invest($gameResult);
        $balance = $this->demoPlay ? @$user->demo_balance : @$user->balance;
        $res['game_log_id'] = @$invest['game_log']->id;
        $res['balance'] = showAmount($balance, currencyFormat: false);
        if ($this->resultShowOnStart) {
            $res['result'] = $gameResult['result'];
        }
        if ($this->extraResponseOnStart) {
            $res = array_merge($res, $this->extraResponseOnStart);
        }
        if ($this->fromApi) {
            $notify[] = $this->game->name . ' investment data';
            return responseSuccess('investment_data', $notify, $res);
        }
        return response()->json($res);
    }

    public function complete()
    {
        if ($this->extraEndValidationRule) {
            $validator = Validator::make($this->request->all(), $this->extraEndValidationRule);
            if ($validator->fails()) {
                if ($this->fromApi) {
                    return responseError('validation_error', $validator->errors()->all());
                }
                return response()->json(['errors' => $validator->errors()->all()]);
            }
        }
        if (!$this->game) {
            if ($this->fromApi) {
                $notify[] = 'Game not found';
                return responseError('not_found', $notify);
            }
            return response()->json(['error' => 'Game not found']);
        }
        $gameLog = GameLog::where('user_id', $this->user->id)->where('id', $this->request->game_log_id)->first();
        if (!$gameLog) {
            if ($this->fromApi) {
                $notify[] = 'Game Logs not found';
                return responseError('not_found', $notify);
            }
            return response()->json(['error' => 'Game Logs not found']);
        }

        if($gameLog->status == Status::YES){
            if ($this->fromApi){
                $notify[] = 'Game Log already completed';
                return responseError('game_completed', $notify);
            }
            return response()->json(['error' => 'Game Log already completed']);
        }
        $trx = getTrx();

        if ($this->hasCustomCompleteLogic) {
            $customCompleteLogic = $this->customCompleteLogic($gameLog);
            if ($customCompleteLogic['should_return']) {
                if ($this->fromApi) {
                    if (@$customCompleteLogic['data']['error']) {
                        $notify[] = @$customCompleteLogic['data']['error'];
                        return responseError('error', $notify);
                    }
                    $notify[] = @$customCompleteLogic['data']['message'] ?? 'Success Data';
                    return responseSuccess('success_data', $notify, $customCompleteLogic['data']);
                }
                return response()->json($customCompleteLogic['data']);
            }
        }

        if ($gameLog->win_status != Status::LOSS) {
            $winBon     = $gameLog->win_amo != 0 ? $gameLog->win_amo : $gameLog->invest * $this->game->win / 100;
            $amount     = $winBon;
            $investBack = 0;

            if ($this->game->invest_back == Status::YES) {
                $investBack = $gameLog->invest;
                if ($this->demoPlay) {
                    $this->user->demo_balance += $gameLog->invest;
                } else {
                    $this->user->balance += $gameLog->invest;
                }
                $this->user->save();
                if (!$this->demoPlay) {
                    $transaction               = new Transaction();
                    $transaction->user_id      = $this->user->id;
                    $transaction->amount       = $investBack;
                    $transaction->charge       = 0;
                    $transaction->trx_type     = '+';
                    $transaction->details      = 'Invest Back For ' . $this->game->name;
                    $transaction->remark       = 'invest_back';
                    $transaction->trx          = $trx;
                    $transaction->post_balance = $this->user->balance;
                    $transaction->save();
                }
            }

            if ($this->demoPlay) {
                $this->user->demo_balance += $amount;
            } else {
                $this->user->balance += $amount;
            }
            $this->user->save();

            $gameLog->win_amo = $amount;
            $gameLog->save();

            if (!$this->demoPlay) {
                $transaction               = new Transaction();
                $transaction->user_id      = $this->user->id;
                $transaction->amount       = $winBon;
                $transaction->charge       = 0;
                $transaction->trx_type     = '+';
                $transaction->details      = 'Win bonus of ' . $this->game->name;
                $transaction->remark       = 'Win_Bonus';
                $transaction->trx          = $trx;
                $transaction->post_balance = $this->user->balance;
                $transaction->save();
            }

            $res['message'] = 'Yahoo! You Win!!!';
            $res['type']    = 'success';
        } else {
            $res['message'] = 'Oops! You Lost!!';
            $res['type']    = 'danger';
        }

        if ($this->extraResponseOnEnd) {
            $res = array_merge($res, $this->extraResponseOnEnd);
        }

        $balance = $this->demoPlay ? @$this->user->demo_balance : @$this->user->balance;

        $res['result']      = in_array($this->game->alias, ['keno']) ? json_decode($gameLog->result) : $gameLog->result;
        $res['user_choose'] = in_array($this->game->alias, ['keno']) ? json_decode($gameLog->user_select) : $gameLog->user_select;
        $res['win_status']  = $gameLog->win_status;
        $res['bal']         = showAmount($balance, currencyFormat: false);

        $gameLog->status = Status::GAME_FINISHED;
        $gameLog->save();

        if ($this->fromApi) {
            $notify[] = $this->game->name . ' result data';
            return responseSuccess('result_data', $notify, $res);
        }
        return $res;
    }

    private function getValidationRules()
    {
        return array_merge($this->globalValidationRule, $this->extraValidationRule);
    }

    private function fallback()
    {
        $balance = $this->demoPlay ? @$this->user->demo_balance : @$this->user->balance;
        if ($this->request->invest > $balance) {
            return ['error' => 'Oops! You have no sufficient balance'];
        }
        $running = GameLog::where('status', 0)->where('user_id', @$this->user->id)->where('game_id', $this->game->id)->first();
        if ($running) {
            return ['error' => '1 game is in-complete. Please wait'];
        }
        if ($this->request->invest > $this->game->max_limit) {
            return ['error' => 'Please follow the maximum limit of invest'];
        }
        if ($this->request->invest < $this->game->min_limit) {
            return ['error' => 'Please follow the minimum limit of invest'];
        }
        return ['success'];
    }

    private function invest($gameResult)
    {
        $user = $this->user;
        if ($this->demoPlay) {
            $user->demo_balance -= $this->request->invest;
        } else {
            $user->balance -= $this->request->invest;
        }
        $user->save();

        if (!$this->demoPlay) {
            $transaction               = new Transaction();
            $transaction->user_id      = $user->id;
            $transaction->amount       = $this->request->invest;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Invest to ' . $this->game->name;
            $transaction->remark       = 'invest';
            $transaction->trx          = getTrx();
            $transaction->post_balance = $user->balance;
            $transaction->save();
        }

        $gameLog                 = new GameLog();
        $gameLog->user_id        = $user->id ?? 0;
        $gameLog->game_id        = $this->game->id;
        if ($this->demoPlay) {
            $gameLog->demo_play  = Status::YES;
        }
        $gameLog->user_select    = $this->userSelect;
        $gameLog->result         = in_array($this->game->alias, ['number_slot', 'roulette', 'keno', 'poker', 'blackjack']) ? json_encode($gameResult['result']) : $gameResult['result'];
        $gameLog->status         = 0;
        $gameLog->win_status     = @$gameResult['win_status'] ?? 0;
        $gameLog->invest         = $this->request->invest;
        $gameLog->win_amo        = @$gameResult['win_amount'] ?? 0;
        $gameLog->mines          = @$this->request->mines ?? 0;
        $gameLog->mine_available = @$this->request->mines ?? 0;
        $gameLog->save();
        return ['game_log' => $gameLog];
    }
}
