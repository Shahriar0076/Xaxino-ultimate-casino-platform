<?php

namespace App\Games;

use App\Constants\Status;
use App\Models\GuessBonus;
use App\Models\Game as GameModel;

class NumberGuess extends Game
{
    protected $alias = 'number_guess';
    protected $hasCustomCompleteLogic = true;
    protected $extraEndValidationRule = [
        'number' => 'required|integer|between:0,100',
    ];
    protected function gameResult()
    {
        $winLossData['result'] = mt_rand(1, 100);
        return $winLossData;
    }

    protected function customCompleteLogic($gameLog)
    {
        if ($gameLog->user_select != null) {
            $userSelect = json_decode($gameLog->user_select);
            array_push($userSelect, $this->request->number);
        } else {
            $userSelect[] = $this->request->number;
        }
        $game = GameModel::find($gameLog->game_id);
        $data  = GuessBonus::where('alias', $game->alias)->get();
        $count = $data->count();

        if ($gameLog->status == 1) {
            $res['gameSt'] = 1;
            $res['message'] = 'Time Over';
            return ['should_return' => true, 'data' => $res];
        }

        $gameLog->try         = $gameLog->try + 1;
        $gameLog->user_select = json_encode($userSelect);
        if ($gameLog->try >= $count) {
            $gameLog->status = Status::ENABLE;
        }
        $gameLog->save();

        $bonus = GuessBonus::where('alias', $game->alias)->where('chance', $gameLog->try)->first()->percent;
        $amount = $gameLog->invest * $bonus / 100;

        $result = $gameLog->result;
        if ($this->request->number < $result) {
            $mes['message'] = 'The Number is short';
            $mes['type']    = 0;
        }

        if ($this->request->number > $result) {
            $mes['message'] = 'The Number is high';
            $mes['type']    = 1;
        }

        if ($gameLog->status == 1) {
            $mes['gameSt']     = 1;
            $mes['message']    = 'Oops You Lost! The Number was ' . $gameLog->result;
            $mes['win_status'] = 0;
            $mes['result'] = $gameLog->result;
        } else {
            $nextBonus   = GuessBonus::where('alias', $game->alias)->where('chance', $gameLog->try + 1)->first();
            $mes['data'] = $nextBonus->percent . '%';
        }

        if ($this->request->number == $result) {
            $gameLog->win_status = Status::WIN;
            $gameLog->status     = Status::ENABLE;
            $gameLog->win_amo    = $amount;
            $gameLog->save();

            $mes['gameSt']     = 1;
            $mes['win_status'] = 1;
            $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, $mes);
            return ['should_return' => false];
        }
        return ['should_return' => true, 'data' => $mes];
    }
}
