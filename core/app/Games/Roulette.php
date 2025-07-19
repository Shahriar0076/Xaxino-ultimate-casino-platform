<?php

namespace App\Games;

use App\Constants\Status;

class Roulette extends Game
{
    protected $alias = 'roulette';
    protected $resultShowOnStart = true;
    protected $extraValidationRule = [
        'choose' => 'required|in:1_12,13_24,25_36,1_18,19_36,even,odd,red,black,2_1_1,2_1_2,2_1_3,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36'
    ];

    protected function gameResult()
    {
        if ($this->request->choose == '1_12') {
            $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        } else if ($this->request->choose == '13_24') {
            $numbers = [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24];
        } else if ($this->request->choose == '25_36') {
            $numbers = [25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36];
        } else if ($this->request->choose == '1_18') {
            $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
        } else if ($this->request->choose == '19_36') {
            $numbers = [19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36];
        } else if ($this->request->choose == 'even') {
            $numbers = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36];
        } else if ($this->request->choose == 'odd') {
            $numbers = [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31, 33, 35];
        } else if ($this->request->choose == 'red') {
            $numbers = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];
        } else if ($this->request->choose == 'black') {
            $numbers = [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35];
        } else if ($this->request->choose == '2_1_1') {
            $numbers = [3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36];
        } else if ($this->request->choose == '2_1_2') {
            $numbers = [2, 5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35];
        } else if ($this->request->choose == '2_1_3') {
            $numbers = [1, 4, 7, 10, 13, 16, 19, 22, 25, 28, 31, 34];
        } else {
            $numbers = [$this->request->choose];
        }

        $random = rand(1, 36);
        if (in_array($random, $numbers)) {
            $win = Status::WIN;
        } else {
            $win = Status::LOSS;
        }
        $winAmount = $this->request->invest * (36 / count($numbers));
        $winLossData['win_status'] = $win;
        $winLossData['result'] = $random;
        $winLossData['win_amount'] = $winAmount;
        return $winLossData;
    }
}
