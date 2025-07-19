<?php

namespace App\Games;

use App\Constants\Status;

class BlackJack extends Game
{
    protected $alias = 'blackjack';
    protected $hasCustomCompleteLogic = true;

    protected function gameResult()
    {
        $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        $types  = ["C", "D", "H", "S"];
        $deck   = [];
        for ($i = 0; $i < count($types); $i++) {
            for ($j = 0; $j < count($values); $j++) {
                $deck[] = $values[$j] . "-" . $types[$i];
            }
        }
        for ($a = 0; $a < count($deck); $a++) {
            $randValue = ((float) rand() / (float) getrandmax()) * count($deck);
            $b         = (int) floor($randValue);
            $temp      = $deck[$a];
            $deck[$a]  = $deck[$b];
            $deck[$b]  = $temp;
        }

        $dealerSum = 0;
        $userSum   = 0;

        $dealerAceCount = 0;
        $userAceCount   = 0;

        $hidden = array_pop($deck);
        $dealerSum += $this->getValue($hidden);
        $dealerAceCount += $this->checkAce($hidden);

        while ($dealerSum < 17) {
            $dealerCard      = array_pop($deck);
            $dealerCardImg[] = $dealerCard;
            $dealerSum       = $dealerSum + $this->getValue($dealerCard);
            $dealerAceCount += $this->checkAce($dealerCard);
        }

        for ($m = 0; $m < 2; $m++) {
            $card      = array_pop($deck);
            $cardImg[] = $card;
            $userSum += $this->getValue($card);
            $userAceCount += $this->checkAce($card);
        }

        $dealerResult = array_merge([$hidden], $dealerCardImg);
        $this->userSelect = json_encode($cardImg);
        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, [
            'dealerSum'      => $dealerSum,
            'dealerAceCount' => $dealerAceCount,
            'userSum'        => $userSum,
            'userAceCount'   => $userAceCount,
            'dealerCardImg'  => $dealerCardImg,
            'cardImg'        => $cardImg,
            'card'           => $deck,
        ]);
        $winLossData['win_status'] = 0;
        $winLossData['result'] = $dealerResult;

        return $winLossData;
    }

    private function getValue($card)
    {
        $data  = explode("-", $card);
        $value = $data[0];
        if ($value == 'A' || $value == 'K' || $value == 'Q' || $value == 'J') {
            if ($value == "A") {
                return 11;
            }
            return 10;
        }
        return (int) $value;
    }

    private function checkAce($card)
    {
        if ($card[0] == "A") {
            return 1;
        }
        return 0;
    }

    protected function customCompleteLogic($gameLog)
    {
        if ($this->request->type == 'hit') {
            return $this->hitGame($gameLog);
        } else {
            return $this->stayGame($gameLog);
        }
    }

    private function hitGame($gameLog)
    {
        $userSum      = $this->request->userSum;
        $userAceCount = $this->request->userAceCount;
        $reduceAce    = $this->reduceAce($userSum, $userAceCount);

        if ($reduceAce > 21) {
            return [
                'should_return' => true,
                'data' => ['error' => 'You can\'t hit more']
            ];
        }

        $deck      = $this->request->card;
        $card      = array_pop($deck);
        $cardImg[] = $card;
        $userSum += $this->getValue($card);
        $userAceCount += $this->checkAce($card);

        $oldCard              = json_decode($gameLog->user_select);
        $newCard              = array_merge($oldCard, [$card]);
        $gameLog->user_select = json_encode($newCard);
        $gameLog->save();
        return [
            'should_return' => true,
            'data' => [
                'dealerAceCount' => $this->request->dealerAceCount,
                'userSum'        => $userSum,
                'userAceCount'   => $userAceCount,
                'cardImg'        => $cardImg,
                'game_log_id'    => $gameLog->id,
                'card'           => $deck,
            ]
        ];
    }

    private function stayGame($gameLog)
    {
        $userSelectCard = json_decode($gameLog->user_select);
        $userCardSum    = 0;
        foreach ($userSelectCard as $userCard) {
            $userCardSum += $this->getValue($userCard);
        }

        $dealerSelectCard = json_decode($gameLog->result);
        $dealerCardSum    = 0;
        foreach ($dealerSelectCard as $dealerCard) {
            $dealerCardSum += $this->getValue($dealerCard);
        }

        $userAceCount   = $this->request->userAceCount;
        $dealerAceCount = $this->request->dealerAceCount;
        $hiddenImage    = $dealerSelectCard[0];

        $userSum   = $this->reduceAce($userCardSum, $userAceCount);
        $dealerSum = $this->reduceAce($dealerCardSum, $dealerAceCount);

        if ($userSum > 21) {
            $gameLog->win_status = Status::LOSS;
            $winStatus           = 'Loss';
        } else if ($dealerSum > 21) {
            $gameLog->win_status = Status::WIN;
            $winStatus           = 'Win';
        } else if ($userSum == $dealerSum) {
            $gameLog->win_status = Status::WIN;
            $winStatus           = 'Tie';
        } else if ($userSum > $dealerSum) {
            $gameLog->win_status = Status::WIN;
            $winStatus           = 'Win';
        } else if ($userSum < $dealerSum) {
            $gameLog->win_status = Status::LOSS;
            $winStatus           = 'Loss';
        }
        $gameLog->save();

        $this->extraResponseOnEnd = array_merge($this->extraResponseOnEnd, [
            'hiddenImage' => $hiddenImage,
            'win_status'  => $winStatus,
            'userSum'     => $userSum,
            'dealerSum'   => $dealerSum,
            'game_log_id' => $gameLog->id,
        ]);

        if ($winStatus == 'Tie') {
            $this->game->invest_back = Status::YES;
        }

        return ['should_return' => false];
    }

    private function reduceAce($userSum, $userAceCount)
    {
        while ($userSum > 21 && $userAceCount > 0) {
            $userSum -= 10;
            $userAceCount -= 1;
        }
        return $userSum;
    }
}
