<?php

namespace App\Games;

use App\Constants\Status;

class HeadTail extends Game
{
    protected $alias = 'head_tail';
    protected $resultShowOnStart = true;
    protected $extraValidationRule = [
        'choose' => 'required|in:head,tail'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = $this->request->choose;
        } else {
            $winLossData['win_status'] = Status::LOSS;
            $winLossData['result'] = $this->request->choose == 'head' ? 'tail' : 'head';
        }
        return $winLossData;
    }
}
