<?php

namespace App\Games;

use App\Constants\Status;

class ColorPrediction extends Game
{
    protected $alias = 'color_prediction';
    protected $extraValidationRule = [
        'choose' => 'required|in:green,violet,red,0,1,2,3,4,5,6,7,8,9'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $win = Status::WIN;
        } else {
            $win = Status::LOSS;
        }

        $ratio        = 0;
        $resultOption = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        if ($this->request->choose == 'green') {
            $greenResultOption = [1, 3, 5, 7, 9];
            if ($win) {
                $result = $greenResultOption[array_rand($greenResultOption)];
                $ratio  = ($result == 5) ? 1.5 : 2;
            } else {
                $otherResultOption = array_diff($resultOption, $greenResultOption);
                $result = $otherResultOption[array_rand($otherResultOption)];
            }
        } else if ($this->request->choose == 'violet') {
            $violetResultOption = [0, 5];
            if ($win) {
                $result = $violetResultOption[array_rand($violetResultOption)];
                $ratio = 4.5;
            } else {
                $otherResultOption = array_diff($resultOption, $violetResultOption);
                $result = $otherResultOption[array_rand($otherResultOption)];
            }
        } else if ($this->request->choose == 'red') {
            $redResultOption = [2, 4, 6, 8, 0];
            if ($win) {
                $result = $redResultOption[array_rand($redResultOption)];
                $ratio = ($result == 0) ? 1.5 : 2;
            } else {
                $otherResultOption = array_diff($resultOption, $redResultOption);
                $result = $otherResultOption[array_rand($otherResultOption)];
            }
        } else {
            if ($win) {
                $result = $this->request->choose;
                $ratio = 9;
            } else {
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $result = $otherResultOption[array_rand($otherResultOption)];
            }
        }
        $winAmount = $this->request->invest * $ratio;
        $winLossData['win_status'] = $win;
        $winLossData['result'] = $result;
        $winLossData['win_amount'] = $winAmount;
        return $winLossData;
    }
}
