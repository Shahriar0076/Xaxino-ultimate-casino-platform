<?php

namespace App\Games;

use App\Constants\Status;

class AndarBahar extends Game
{
    protected $alias = 'andar_bahar';
    protected $extraValidationRule = [
        'choose' => 'required|in:andar,bahar'
    ];

    protected function deck()
    {
        $suits = ['H', 'D', 'C', 'S'];
        $ranks = range(2, 10);
        $faceCards = ['J', 'Q', 'K', 'A'];
        $deck = [];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $deck[] = "{$rank}-{$suit}";
            }
            foreach ($faceCards as $face) {
                $deck[] = "{$face}-{$suit}";
            }
        }
        return $deck;
    }

    protected function winLoss()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $winLossData['win_status'] = Status::WIN;
            $winLossData['result'] = $this->request->choose;
        } else {
            $winLossData['win_status'] = Status::LOSS;
            $winLossData['result'] = $this->request->choose == 'andar' ? 'bahar' : 'andar';
        }
        return $winLossData;
    }

    protected function sendTempResultCard($card, $deck, $randomCard)
    {
        if ($card[0] != $randomCard[0]) {
            return $card;
        }
        return $this->sendTempResultCard(array_pop($deck), $deck, $randomCard);
    }

    protected function gameResult()
    {
        $deck = $this->deck();
        shuffle($deck);
        $randomCard = array_pop($deck);

        $andarCards = [];
        $baharCards = [];

        $turn = 'andar';
        $winLossData = $this->winLoss();
        $maxIterations = 50;
        $iteration = 0;
        while (!empty($deck) && $iteration < $maxIterations) {
            $iteration++;
            $drawnCard = array_pop($deck);
            if ($turn === 'andar') {
                $andarCards[] = $drawnCard;
                if ($drawnCard[0] == $randomCard[0]) {
                    if ($winLossData['win_status'] == Status::WIN && $this->request->choose == 'andar') {
                        break;
                    } else {
                        if ($this->request->choose == 'bahar' && $winLossData['win_status'] == Status::LOSS) {
                            break;
                        } else {
                            $tempResultCard = array_pop($andarCards);
                            $newCard = $this->sendTempResultCard(array_pop($deck), $deck, $randomCard);
                            if ($newCard !== null) {
                                $andarCards[] = $newCard;
                                $deck[] = $tempResultCard;
                            }
                        }
                    }
                }
                $turn = 'bahar';
            } else {
                $baharCards[] = $drawnCard;
                if ($drawnCard[0] == $randomCard[0]) {
                    if ($winLossData['win_status'] == Status::WIN && $this->request->choose == 'bahar') {
                        break;
                    } else {
                        if ($this->request->choose == 'andar' && $winLossData['win_status'] == Status::LOSS) {
                            break;
                        } else {
                            $tempResultCard = array_pop($baharCards);
                            $newCard = $this->sendTempResultCard(array_pop($deck), $deck, $randomCard);
                            if ($newCard !== null) {
                                $baharCards[] = $newCard;
                                $deck[] = $tempResultCard;
                            }
                        }
                    }
                }
                $turn = 'andar';
            }
        }

        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, [
            'randomCard' => $randomCard,
            'andarCards' => $andarCards,
            'baharCards' => $baharCards
        ]);
        return $winLossData;
    }
}
