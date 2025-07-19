<?php

namespace App\Games;

use App\Constants\Status;

class CardFinding extends Game
{
    protected $alias = 'card_finding';
    protected $resultShowOnStart = true;
    protected $extraValidationRule = [
        'choose' => 'required|in:black,red'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = ($this->request->choose == 'black') ? 'BLACK' : 'RED';
        } else {
            $winLossData['win_status'] = Status::LOSS;
            $winLossData['result'] = ($this->request->choose == 'black') ? 'RED' : 'BLACK';
        }
        return $winLossData;
    }
}
