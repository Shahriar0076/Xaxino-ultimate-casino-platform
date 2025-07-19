<?php

namespace App\Games;

use App\Constants\Status;

class DreamCatcher extends Game
{
    protected $alias = 'dream_catcher';
    protected $hasCustomCompleteLogic = true;
    protected $extraValidationRule = [
        'choose' => 'required|in:1,2,5,10,20,40,2x,7x'
    ];

    protected function gameResult()
    {
        $result = null;
        $point = null;
        $spinStatus = false;
        $winAmount = 0;
        $random = mt_rand(0, 100);
        $probableWin = $this->getWinValue($this->request->choose);
        $resultOption = [1, 2, 5, 10, 20, 40];

        if ($random <= $probableWin) {
            $win = Status::WIN;
            $result = $this->request->choose;
            $point = $result;
            $random = mt_rand(0, 100);
            if ($random <= $this->game->probable_win->twox) {
                $resultOption = [1, 2, 5, 10, 20, 40, '2x'];
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $tempPoint = $otherResultOption[array_rand($otherResultOption)];
                if ($tempPoint == '2x') {
                    $point = $tempPoint;
                    $spinStatus = true;
                }
            } elseif ($random <= $this->game->probable_win->sevenx) {
                $resultOption = [1, 2, 5, 10, 20, 40, '2x', '7x'];
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $tempPoint = $otherResultOption[array_rand($otherResultOption)];
                if ($tempPoint == '7x') {
                    $point = $tempPoint;
                    $spinStatus = true;
                }
            }
        } else {
            $win = Status::LOSS;
        }

        if (in_array($this->request->choose, $resultOption)) {
            if ($win) {
                $tempWinAmount = null;
                if ($spinStatus && $point == '2x') {
                    $tempWinAmount = 2;
                }
                if ($spinStatus && $point == '7x') {
                    $tempWinAmount = 7;
                }
                switch ($result) {
                    case 1:
                        $winAmount = ($tempWinAmount ?? 1) * $this->request->invest * 1;
                        break;
                    case 2:
                        $winAmount = ($tempWinAmount ?? 1) * $this->request->invest * 2;
                        break;
                    case 5:
                        $winAmount = ($tempWinAmount ?? 1) * $this->request->invest * 5;
                        break;
                    case 10:
                        $winAmount = ($tempWinAmount ?? 1) * $this->request->invest * 10;
                        break;
                    case 20:
                        $winAmount = ($tempWinAmount ?? 1) * $this->request->invest * 20;
                        break;
                    case 40:
                        $winAmount = ($tempWinAmount ?? 1) * $this->request->invest * 40;
                        break;
                }
            } else {
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $point = $otherResultOption[array_rand($otherResultOption)];
                $result = $point;
            }
        }
        $winLossData['win_amount'] = $winAmount;
        $winLossData['win_status'] = $win;
        $winLossData['result'] = $result;
        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, [
            'point' => $point,
            'reSpin' => $spinStatus
        ]);
        return $winLossData;
    }

    private function getWinValue($value)
    {
        switch ($value) {
            case '1':
                return (int) $this->game->probable_win->one;
            case '2':
                return (int) $this->game->probable_win->two;
            case '5':
                return (int) $this->game->probable_win->five;
            case '10':
                return (int) $this->game->probable_win->ten;
            case '20':
                return (int) $this->game->probable_win->twenty;
            case '40':
                return (int) $this->game->probable_win->forty;
        }
    }

    public function customCompleteLogic($gameLog)
    {
        if ($this->request->re_spin == 'true') {
            $point = $gameLog->result;
            $spinStatus = false;
            $random = mt_rand(0, 100);
            if ($random <= $this->game->probable_win->twox) {
                $resultOption = [1, 2, 5, 10, 20, 40, '2x'];
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $tempPoint = $otherResultOption[array_rand($otherResultOption)];
                if ($tempPoint == '2x') {
                    $point = $tempPoint;
                    $spinStatus = true;
                }
            } elseif ($random <= $this->game->probable_win->sevenx) {
                $resultOption = [1, 2, 5, 10, 20, 40, '2x', '7x'];
                $otherResultOption = array_diff($resultOption, [$this->request->choose]);
                $tempPoint = $otherResultOption[array_rand($otherResultOption)];
                if ($tempPoint == '7x') {
                    $point = $tempPoint;
                    $spinStatus = true;
                }
            }
            if ($spinStatus) {
                $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, [
                    'point' => $point,
                ]);
                $tempWinAmount = null;
                if ($spinStatus && $point == '2x') {
                    $tempWinAmount = 2;
                }
                if ($spinStatus && $point == '7x') {
                    $tempWinAmount = 7;
                }
                $gameLog->win_amo = $gameLog->win_amo * $tempWinAmount;
                $gameLog->save();
                $res['point'] = $point;
                $res['reSpin'] = $spinStatus;
                $res['game_log_id'] = $gameLog->id;
                return [
                    'should_return' => true,
                    'data'          => $res
                ];
            } else {
                if ($gameLog->win_status == Status::WIN) {
                    $gameLog->win_amo = $gameLog->win_amo + $gameLog->invest;
                    $gameLog->save();
                }
                $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, [
                    'point' => $gameLog->result,
                    'reSpin' => false,
                ]);
                return ['should_return' => false];
            }
        } else {
            if ($gameLog->win_status == Status::WIN) {
                $gameLog->win_amo = $gameLog->win_amo + $gameLog->invest;
                $gameLog->save();
            }
            $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, [
                'point' => $gameLog->result,
                'reSpin' => false,
            ]);
            return ['should_return' => false];
        }
    }
}
