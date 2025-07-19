<?php

namespace App\Games;

use App\Constants\Status;

class RockPaperScissors extends Game
{
    protected $alias = 'rock_paper_scissors';
    protected $extraValidationRule = [
        'choose' => 'required|in:rock,paper,scissors'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        $userChoose = $this->request->choose;
        if ($random <= $this->game->probable_win) {
            if ($userChoose == 'rock') {
                $result = 'SCISSORS';
            }
            if ($userChoose == 'paper') {
                $result = 'ROCK';
            }
            if ($userChoose == 'scissors') {
                $result = 'PAPER';
            }
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = $result;
        } else {
            if ($userChoose == 'rock') {
                $result = 'PAPER';
            }
            if ($userChoose == 'paper') {
                $result = 'SCISSORS';
            }
            if ($userChoose == 'scissors') {
                $result = 'ROCK';
            }
            $winLossData['win_status'] = Status::LOSS;
            $winLossData['result'] = $result;
        }
        return $winLossData;
    }
}
