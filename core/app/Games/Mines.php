<?php

namespace App\Games;

use App\Constants\Status;
use App\Models\GuessBonus;

class Mines extends Game
{
    protected $alias = 'mines';
    protected $hasCustomCompleteLogic = true;
    protected $extraValidationRule = [
        'mines' => 'required|integer|min:1|max:20'
    ];

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $win           = Status::WIN;
            $result        = $random;
            $availableMine = floor($result / 4);

            if (($this->request->mines + $availableMine) > 25) {
                $moreMines = ($this->request->mines + $availableMine) - 25;
                $availableMine -= $moreMines;
            }
        } else {
            $win           = Status::LOSS;
            $result        = 0;
            $availableMine = 0;
        }
        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, [
            'available_mine' => $availableMine
        ]);
        $winLossData['win_status'] = $win;
        $winLossData['result'] = $result;
        return $winLossData;
    }

    protected function customCompleteLogic($gameLog)
    {
        if ($this->request->type == 'mine') {
            return $this->goldMine($gameLog, @$this->request->count, @$this->request->is_blast);
        } else {
            return $this->cashOut($gameLog, @$this->request->count);
        }
    }

    private function goldMine($gameLog, $count = 0, $isBlast = null)
    {
        $res['mines']            = $gameLog->mines;
        $res['gold_count']       = $gameLog->gold_count;
        $res['mine_image']       = getImage(activeTemplate(true) . 'images/mines/mines.png');
        $res['gold_image']       = getImage(activeTemplate(true) . 'images/mines/gold.png');
        $res['gold_transparent'] = getImage(activeTemplate(true) . 'images/mines/gold_transparent.png');
        if (!$gameLog->result) {
            $res['sound']   = 'mine.mp3';
            $gameLog->win_status     = Status::LOSS;
            $gameLog->mine_available = 0;
            $gameLog->save();
        } else {
            if ($gameLog->mine_available == 0 || $isBlast == 'blast') {
                if ($isBlast == 'blast') {
                    $gameLog->gold_count = $count;
                    $gameLog->mine_available = $gameLog->mines - $count;
                }
                $gameLog->win_status = Status::LOSS;
                $res['sound']   = 'mine.mp3';
            } else {
                $gameLog->gold_count += 1;
                $gameLog->mine_available -= 1;

                $winAmount = 0;
                $mineBonus = GuessBonus::where('alias', $this->game->alias)->where('chance', $gameLog->mines)->first();
                if ($mineBonus) {
                    $winAmount = $gameLog->invest + ($gameLog->invest * ($gameLog->gold_count * $mineBonus->percent) / 100);
                }
                $gameLog->win_amo = $winAmount;

                $res['type']  = 'success';
                $res['sound'] = 'win.wav';
                $gameLog->save();
                return [
                    'should_return' => true,
                    'data' => $res
                ];
            }
        }

        $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, $res);
        return ['should_return' => false];
    }

    private function cashOut($gameLog, $count = 0)
    {
        if ($count) {
            $mineBonus = GuessBonus::where('alias', $this->game->alias)->where('chance', $gameLog->mines)->first();
            if ($mineBonus) {
                $winAmount = $gameLog->invest + ($gameLog->invest * ($count * $mineBonus->percent) / 100);
                $winAmount = $winAmount;
            }
            $gameLog->win_amo = @$winAmount ?? 0;
            $gameLog->win_status = Status::WIN;
            $gameLog->gold_count = $count;
            $gameLog->mine_available = $gameLog->mines - $count;
            $gameLog->save();
        }
        $res['sound'] = 'win.wav';
        $res['success'] = 'Congratulation! you won ' . getAmount($gameLog->win_amo) . ' ' . gs('cur_text');
        $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, $res);
        return ['should_return' => false];
    }
}
