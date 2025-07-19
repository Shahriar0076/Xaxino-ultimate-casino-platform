<?php

namespace App\Games;

use App\Constants\Status;
use App\Models\Transaction;

class NumberSlot extends Game {
    protected $alias                  = 'number_slot';
    protected $resultShowOnStart      = true;
    protected $hasCustomCompleteLogic = true;
    protected $extraValidationRule    = [
        'choose' => 'required|in:0,1,2,3,4,5,6,7,8,9',
    ];

    protected function gameResult() {
        $random = mt_rand(0, 100);
        if ($this->game->probable_win[0] > $random) {
            $result = $this->numberSlotResult(0, $this->request->choose);
            $win    = 0;
        } else if ($this->game->probable_win[0] + $this->game->probable_win[1] > $random) {
            $result = $this->numberSlotResult(1, $this->request->choose);
            $win    = 1;
        } else if ($this->game->probable_win[0] + $this->game->probable_win[1] + $this->game->probable_win[2] > $random) {
            $result = $this->numberSlotResult(2, $this->request->choose);
            $win    = 2;
        } else {
            $result = $this->numberSlotResult(3, $this->request->choose);
            $win    = 3;
        }
        $winLossData['win_status'] = $win;
        $winLossData['result']     = $result;
        return $winLossData;
    }

    protected function customCompleteLogic($gameLog) {
        $game   = $this->game;
        $user   = $this->user;
        $trx    = getTrx();
        $winner = 0;
        foreach ($game->level as $key => $data) {
            if ($gameLog->win_status == $key + 1) {
                $winBon = $gameLog->invest * $game->level[$key] / 100;
                $amount = $winBon;

                if ($this->demoPlay) {
                    $this->user->demo_balance += $amount;
                } else {
                    $this->user->balance += $amount;
                }
                $this->user->save();

                $gameLog->win_amo = $amount;
                $gameLog->save();

                $winner = 1;
                $lev    = $key + 1;

                if (!$this->demoPlay) {
                    $transaction               = new Transaction();
                    $transaction->user_id      = $user->id;
                    $transaction->amount       = $winBon;
                    $transaction->charge       = 0;
                    $transaction->trx_type     = '+';
                    $transaction->details      = $game->level[$key] . '% Win bonus of Number Slot Game ' . $lev . ' Time';
                    $transaction->remark       = 'win_bonus';
                    $transaction->trx          = $trx;
                    $transaction->post_balance = $user->balance;
                    $transaction->save();
                }
            }
        }
        $balance            = $this->demoPlay ? @$this->user->demo_balance : @$this->user->balance;
        $res['user_choose'] = $gameLog->user_select;
        $res['bal']         = showAmount($balance, currencyFormat: false);
        $res['result']      = $gameLog->result;
        if ($winner == 1) {
            $res['message']    = 'Yahoo! You Win for ' . $gameLog->win_status . ' Time !!!';
            $res['win_status'] = Status::WIN;
        } else {
            $res['message']    = 'Oops! You Lost!!';
            $res['win_status'] = Status::LOSS;
        }

        $gameLog->status = Status::ENABLE;
        $gameLog->save();

        return [
            'should_return' => true,
            'data'          => $res,
        ];
    }

    private function numberSlotResult($win, $num) {
        for ($i = 0; $i < $win; $i++) {
            $res[] = (int) $num;
        }

        $left = 3 - $win;
        while ($left > 0) {
            $newRand = mt_rand(0, 9);
            if ($newRand != $num) {
                $res[] = $newRand;
                $left--;
            }
        }
        shuffle($res);
        return $res;
    }
}
