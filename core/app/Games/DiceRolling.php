<?php

namespace App\Games;

use App\Constants\Status;

class DiceRolling extends Game
{
    protected $alias = 'dice_rolling';
    protected $resultShowOnStart = true;
    protected $extraValidationRule = [
        'choose' => 'required|in:1,2,3,4,5,6'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = $this->request->choose;
        } else {

            for ($i = 0; $i < 100; $i++) {
                $randWin = rand(1, 6);

                if ($randWin != $this->request->choose) {
                    $result = $randWin;
                    break;
                }
            }

            $winLossData['win_status'] = Status::LOSS;
            $winLossData['result'] = $result;
        }
        return $winLossData;
    }
}
