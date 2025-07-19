<?php

namespace App\Games;

use App\Constants\Status;

class Keno extends Game
{
    protected $alias = 'keno';
    protected $extraValidationRule = [
        'choose' => 'required|array|min:1|max:80'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = $this->request->choose;
        } else {
            $winLossData['win_status'] = Status::LOSS;
            $winLossData['result'] = $this->request->choose;
        }
        $winAmount       = 0;
        $maxSelectNumber = @$this->game->level->max_select_number;
        if ($winLossData['win_status'] == 1) {
            $getRandNumber    = rand(4, @$maxSelectNumber);
            $getNewSlotNumber = array_slice($winLossData['result'], 0, $getRandNumber, true);
            $matchNumber      = $getNewSlotNumber;
            while (count($getNewSlotNumber) < $maxSelectNumber) {
                $randomValue = rand(1, 80);
                if (!in_array($randomValue, $getNewSlotNumber) && !in_array($randomValue, $winLossData['result'])) {
                    array_push($getNewSlotNumber, (string) $randomValue);
                }
            }
            $winLossData['result'] = $getNewSlotNumber;
            $commission = array_reduce($this->game->level->levels, function ($carry, $element) use ($getRandNumber) {
                if ((int) $element->level === $getRandNumber) {
                    $carry = $element->percent;
                }
                return $carry;
            });
            $winAmount = $this->request->invest + ($this->request->invest * $commission / 100);
        } else {
            $loseSlotNumber = [];
            while (count($loseSlotNumber) < $maxSelectNumber) {
                $randomValue = rand(1, 80);
                if (!in_array($randomValue, $loseSlotNumber) && !in_array($randomValue, $winLossData['result'])) {
                    array_push($loseSlotNumber, (string) $randomValue);
                }
            }
            $winLossData['result']      = $loseSlotNumber;
            $matchNumber = [];
        }

        $winLossData['win_amount'] = $winAmount;

        $this->userSelect = json_encode($this->request->choose);
        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, [
            'match_number' => $matchNumber,
            'user_select' => $this->request->choose
        ]);

        return $winLossData;
    }
}
