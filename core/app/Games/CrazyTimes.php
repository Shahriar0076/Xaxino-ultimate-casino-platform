<?php

namespace App\Games;

use App\Constants\Status;

class CrazyTimes extends Game
{
    protected $alias = 'crazy_times';
    protected $extraValidationRule = [
        'choose' => 'required|in:1,2,5,10,coin_flip,pachinko,cash_hunt,crazy_times'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $win = Status::WIN;
        } else {
            $win = Status::LOSS;
        }
        $resultOption = [1, 2, 5, 10, 'coin_flip', 'pachinko', 'cash_hunt', 'crazy_times'];
        $winAmount    = 0;
        $result       = null;
        if (in_array($this->request->choose, $resultOption)) {
            if ($win) {
                $result = $this->request->choose;
                switch ($result) {
                    case 1:
                        $winAmount = $this->request->invest + $this->request->invest * 1;
                        break;
                    case 2:
                        $winAmount = $this->request->invest + $this->request->invest * 2;
                        break;
                    case 5:
                        $winAmount = $this->request->invest + $this->request->invest * 5;
                        break;
                    case 10:
                        $winAmount = $this->request->invest + $this->request->invest * 10;
                        break;
                    case 'coin_flip':
                        $winAmount = $this->request->invest + ($this->request->invest * ($this->game->level[0] ?? 0) / 100);
                        break;
                    case 'pachinko':
                        $winAmount = $this->request->invest + ($this->request->invest * ($this->game->level[1] ?? 0) / 100);
                        break;
                    case 'cash_hunt':
                        $winAmount = $this->request->invest + ($this->request->invest * ($this->game->level[2] ?? 0) / 100);
                        break;
                    case 'crazy_times':
                        $winAmount = $this->request->invest + ($this->request->invest * ($this->game->level[3] ?? 0) / 100);
                        break;
                }
            } else {
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $result = $otherResultOption[array_rand($otherResultOption)];
            }
        }

        $winLossData['win_amount'] = $winAmount;
        $winLossData['win_status'] = $win;
        $winLossData['result'] = $result;
        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, [
            'point' => $result
        ]);
        return $winLossData;
    }
}
