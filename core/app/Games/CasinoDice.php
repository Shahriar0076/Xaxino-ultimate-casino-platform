<?php

namespace App\Games;

use App\Constants\Status;

class CasinoDice extends Game
{
    protected $alias = 'casino_dice';
    protected $extraValidationRule = [
        'percent' => 'required|numeric|gt:0',
        'choose'  => 'required|in:low,high',
    ];

    protected function gameResult()
    {
        $winChance   = $this->request->percent;
        $amount      = $this->request->invest;
        $lessThan    = $winChance * 100;
        $greaterThan = 9900 - ($winChance * 100) + 99;
        $payout      = round(99 / $winChance, 4);
        $winAmo      = $amount * $payout;
        $allChances  = rand(1, 98);
        $choose      = $this->request->choose;

        if ($winChance >= $allChances) {
            $win = Status::WIN;
        } else {
            $win = Status::LOSS;
        }
        if ($win == Status::WIN) {
            if ($choose == 'low') {
                $number = rand(100, $lessThan);
            } else {
                $number = rand($greaterThan, 9899);
            }
        } else {
            if ($choose == 'low') {
                $number = rand(($lessThan + 1), 9899);
            } else {
                $number = rand(100, ($greaterThan - 1));
            }
        }
        if (strlen((string) $number) < 4) {
            $number = '0' . $number;
        }

        $winLossData['win_status'] = $win;
        $winLossData['win_amount'] = $winAmo;
        $winLossData['result'] = $number;

        return $winLossData;
    }
}
