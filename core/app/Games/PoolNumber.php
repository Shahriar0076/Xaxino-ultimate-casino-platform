<?php

namespace App\Games;

use App\Constants\Status;

class PoolNumber extends Game
{
    protected $alias = 'number_pool';
    protected $resultShowOnStart = true;
    protected $extraValidationRule = [
        'choose' => 'required|in:1,2,3,4,5,6,7,8'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        $winLossData['result'] = 8;
        if ($random <= $this->game->probable_win) {
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = $this->request->choose;
        } else {
            $winLossData['win_status'] = Status::LOSS;
            for ($i = 0; $i < 100; $i++) {
                $randWin = rand(1, 8);

                if ($randWin != $this->request->choose) {
                    $result = $randWin;
                    break;
                }
            }
            $winLossData['result'] = $result;
        }
        return $winLossData;
    }
}
