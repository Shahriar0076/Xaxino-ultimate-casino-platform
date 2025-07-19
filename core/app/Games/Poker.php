<?php

namespace App\Games;

use App\Constants\Status;
use App\Models\GuessBonus;
use App\Models\Transaction;

class Poker extends Game
{
    protected $alias = 'poker';
    protected $hasCustomCompleteLogic = true;

    protected function gameResult()
    {
        $random = mt_rand(0, 100);
        if ($random <= $this->game->probable_win) {
            $win = Status::WIN;

            $rankName = [
                'royal_flush',
                'straight_flush',
                'four_of_a_kind',
                'full_house',
                'flush',
                'straight',
                'three_of_a_kind',
                'two_pair',
                'pair',
                'high_card',
            ];

            $targetRank = $rankName[rand(0, 9)];
            $rankGet    = true;
            while ($rankGet) {
                $hand = $this->generatePokerHand($targetRank);
                $rank = $this->hasSpecificHand($hand);
                if ($rank != 'no_match') {
                    $rankGet = false;
                }
            }
        } else {
            $win  = Status::LOSS;
            $deck = $this->initializeDeck();
            $hand = $this->dealCardsWithoutRank($deck);
            $rank = $this->hasSpecificHand($hand);
        }

        $winLossData['win_status'] = $win;
        $winLossData['result'] = $hand;

        $this->extraResponseOnStart = array_merge($this->extraResponseOnStart, ['message' => getAmount($this->request->invest) . ' ' . gs('cur_text') . ' ' . 'betted successfully']);

        return $winLossData;
    }

    protected function customCompleteLogic($gameLog)
    {
        if ($this->request->type == 'deal') {
            return $this->pokerDeal($gameLog);
        } elseif ($this->request->type == 'call') {
            return $this->pokerCall($gameLog);
        } else {
            return $this->pokerFold($gameLog);
        }
    }

    public function pokerDeal($gameLog)
    {
        $res['result'] = array_slice(json_decode($gameLog->result), 0, 3);
        $res['path']   = asset(activeTemplate(true) . '/images/cards/');
        return [
            'should_return' => true,
            'data'          => $res
        ];
    }

    public function pokerCall($gameLog)
    {
        $rank = $this->hasSpecificHand(json_decode($gameLog->result));
        if ($rank == 'no_match' || $gameLog->win_status == Status::LOSS) {
            $gameLog->status = Status::GAME_FINISHED;
            $gameLog->save();

            $res['message'] = 'Oops! You Lost!!';
            $res['type']    = 'danger';
            $res['sound']   = 'lose.wav';
        } else {
            $ranks = [
                'royal_flush',
                'straight_flush',
                'four_of_a_kind',
                'full_house',
                'flush',
                'straight',
                'three_of_a_kind',
                'two_pair',
                'pair',
                'high_card',
            ];
            $rankNumber = array_search($rank, $ranks);
            $game       = $gameLog->game;
            $bonus      = 0;

            $rankBonus = GuessBonus::where('alias', $game->alias)->where('chance', $rankNumber + 1)->first();
            if ($rankBonus) {
                $bonus = $rankBonus->percent;
            }
            $winAmount = $gameLog->invest + ($gameLog->invest * $bonus / 100);

            $gameLog->win_amo    = $winAmount;
            $gameLog->win_status = Status::WIN;
            $gameLog->status     = Status::GAME_FINISHED;
            $gameLog->save();

            $user = $gameLog->user;
            if ($this->demoPlay) {
                $user->demo_balance += $winAmount;
            } else {
                $user->balance += $winAmount;
            }
            $user->save();

            if (!$this->demoPlay) {
                $transaction               = new Transaction();
                $transaction->user_id      = $user->id;
                $transaction->amount       = $winAmount;
                $transaction->charge       = 0;
                $transaction->trx_type     = '+';
                $transaction->details      = 'Win bonus of ' . $game->name;
                $transaction->remark       = 'Win_Bonus';
                $transaction->trx          = getTrx();
                $transaction->post_balance = $user->balance;
                $transaction->save();
            }
            $balance = $this->demoPlay ? $user->demo_balance : $user->balance;
            $res['message'] = 'Yahoo! You Win!!!';
            $res['type']    = 'success';
            $res['balance'] = showAmount($balance, currencyFormat: false);
            $res['sound']   = 'win.wav';
        }
        $res['rank']   = str_replace("_", " ", $rank);
        $res['result'] = array_slice(json_decode($gameLog->result), 3, 5);
        $res['path']   = asset(activeTemplate(true) . '/images/cards/');
        return [
            'should_return' => true,
            'data'          => $res
        ];
    }

    public function pokerFold($gameLog)
    {
        $gameLog->status = Status::GAME_FINISHED;
        $gameLog->save();

        $res['message'] = 'Oops! You Lost!!';
        $res['type']    = 'danger';
        $res['sound']   = 'lose.wav';
        $res['rank']    = 'no rank';
        return [
            'should_return' => true,
            'data'          => $res
        ];
    }

    private function initializeDeck()
    {
        $suits = ['H', 'D', 'C', 'S'];
        $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $deck  = [];
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $deck[] = $rank . '-' . $suit;
            }
        }
        shuffle($deck);
        return $deck;
    }

    private function generatePokerHand($targetRank)
    {
        $suits = ['H', 'D', 'C', 'S'];
        $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        $hand = [];

        switch ($targetRank) {
            case 'royal_flush':
                $suit = $suits[rand(0, 3)];
                $hand = ["A-$suit", "K-$suit", "Q-$suit", "J-$suit", "10-$suit"];
                break;

            case 'straight_flush':
                $suit       = $suits[rand(0, 3)];
                $startIndex = rand(0, 9);
                for ($i = $startIndex; $i < $startIndex + 5; $i++) {
                    $hand[] = $ranks[$i % 13] . "-$suit";
                }

                usort($hand, function ($a, $b) use ($ranks) {
                    $rankA = array_search(substr($a, 0, -2), $ranks);
                    $rankB = array_search(substr($b, 0, -2), $ranks);
                    return $rankB - $rankA;
                });
                break;

            case 'four_of_a_kind':
                $rank = $ranks[rand(0, 12)];
                $hand = [$rank . '-H', $rank . '-D', $rank . '-C', $rank . '-S', $ranks[rand(0, 12)] . '-H'];

                usort($hand, function ($a, $b) use ($rank) {
                    return substr($a, 0, -2) === $rank ? -1 : 1;
                });
                break;

            case 'full_house':
                $rank1 = $ranks[rand(0, 12)];
                $rank2 = $ranks[rand(0, 12)];
                while ($rank2 == $rank1) {
                    $rank2 = $ranks[rand(0, 12)];
                }
                $hand = [$rank1 . '-H', $rank1 . '-D', $rank1 . '-C', $rank2 . '-S', $rank2 . '-H'];

                usort($hand, function ($a, $b) use ($rank1, $rank2) {
                    $rankA = array_search(substr($a, 0, -2), [$rank1, $rank2]);
                    $rankB = array_search(substr($b, 0, -2), [$rank1, $rank2]);
                    return $rankA - $rankB;
                });
                break;

            case 'flush':
                $suit = $suits[rand(0, 3)];
                for ($i = 0; $i < 5; $i++) {
                    $hand[] = $ranks[rand(0, 12)] . "-$suit";
                }
                usort($hand, function ($a, $b) use ($ranks) {
                    $rankA = array_search(substr($a, 0, -2), $ranks);
                    $rankB = array_search(substr($b, 0, -2), $ranks);
                    return $rankB - $rankA;
                });
                break;

            case 'straight':
                $startIndex = rand(0, 9);
                for ($i = $startIndex; $i < $startIndex + 5; $i++) {
                    $hand[] = $ranks[$i % 13] . '-' . $suits[rand(0, 3)];
                }
                usort($hand, function ($a, $b) use ($ranks) {
                    $rankA = array_search(substr($a, 0, -2), $ranks);
                    $rankB = array_search(substr($b, 0, -2), $ranks);
                    return $rankB - $rankA;
                });
                break;

            case 'three_of_a_kind':
                $rank = $ranks[rand(0, 12)];
                $hand = [$rank . '-H', $rank . '-D', $rank . '-C', $ranks[rand(0, 12)] . '-S', $ranks[rand(0, 12)] . '-H'];
                usort($hand, function ($a, $b) use ($rank) {
                    if (substr($a, 0, -2) === $rank) {
                        return -1;
                    } else if (substr($b, 0, -2) === $rank) {
                        return 1;
                    } else {
                        return 0;
                    }
                });
                break;

            case 'two_pair':
                $rank1 = $ranks[rand(0, 12)];
                $rank2 = $ranks[rand(0, 12)];
                while ($rank2 == $rank1) {
                    $rank2 = $ranks[rand(0, 12)];
                }
                $hand = [$rank1 . '-H', $rank1 . '-D', $rank2 . '-C', $rank2 . '-S', $ranks[rand(0, 12)] . '-H'];
                usort($hand, function ($a, $b) use ($rank1, $rank2) {
                    $rankA = array_search(substr($a, 0, -2), [$rank1, $rank2]);
                    $rankB = array_search(substr($b, 0, -2), [$rank1, $rank2]);
                    return $rankA - $rankB;
                });
                break;

            case 'pair':
                $rank = $ranks[rand(0, 12)];
                $hand = [$rank . '-H', $rank . '-D', $ranks[rand(0, 12)] . '-C', $ranks[rand(0, 12)] . '-S', $ranks[rand(0, 12)] . '-H'];
                usort($hand, function ($a, $b) use ($rank) {
                    if (substr($a, 0, -2) === $rank) {
                        return -1;
                    } else if (substr($b, 0, -2) === $rank) {
                        return 1;
                    } else {
                        return 0;
                    }
                });
                break;

            case 'high_card':
                for ($i = 0; $i < 5; $i++) {
                    $hand[] = $ranks[rand(0, 12)] . '-' . $suits[rand(0, 3)];
                }
                usort($hand, function ($a, $b) use ($ranks) {
                    $rankA = array_search(substr($a, 0, -2), $ranks);
                    $rankB = array_search(substr($b, 0, -2), $ranks);
                    return $rankB - $rankA;
                });
                break;

            default:
                break;
        }

        return $hand;
    }

    private function hasSpecificHand($hand)
    {
        $handTypes = [
            'royal_flush',
            'straight_flush',
            'four_of_a_kind',
            'full_house',
            'flush',
            'straight',
            'three_of_a_kind',
            'two_pair',
            'pair',
            'high_card',
        ];

        foreach ($handTypes as $handType) {
            $methodName = 'is' . str_replace('_', '', ucwords($handType, '_'));
            if ($this->$methodName($hand)) {
                return $handType;
            }
        }
        return 'no_match';
    }

    private function dealCardsWithoutRank($deck)
    {
        $hand = [];
        while (count($hand) < 5) {
            $card = array_shift($deck);

            $currentRank = explode('-', $card)[0];
            $ranksInHand = array_map(function ($c) {
                return explode('-', $c)[0];
            }, $hand);

            if (!in_array($currentRank, $ranksInHand)) {
                $hand[] = $card;
            }
        }
        return $hand;
    }

    public function isRoyalFlush($hand)
    {
        $requiredRanks = ['10', 'J', 'Q', 'K', 'A'];
        $requiredSuits = array_unique(array_map(function ($card) {
            return explode('-', $card)[1];
        }, $hand));

        return count(array_intersect($requiredRanks, $this->getRanks($hand))) === 5
            && count($requiredSuits) === 1;
    }

    private function getRanks($hand)
    {
        return array_map(function ($card) {
            return explode('-', $card)[0];
        }, $hand);
    }

    public function isStraightFlush($hand)
    {
        $ranks = $this->getRanks($hand);
        $suit  = explode('-', $hand[0])[1];

        return count($ranks) === 5
            && count(array_diff($ranks, array_values(range(min($ranks), max($ranks))))) === 0
            && count(array_unique(array_map(function ($card) {
                return explode('-', $card)[1];
            }, $hand))) === 1;
    }

    public function isFourOfAKind($hand)
    {
        $rankCount = array_count_values($this->getRanks($hand));
        return in_array(4, $rankCount);
    }

    public function isFullHouse($hand)
    {
        $rankCount = array_count_values($this->getRanks($hand));
        return in_array(3, $rankCount) && in_array(2, $rankCount);
    }

    public function isFlush($hand)
    {
        $suits = array_map(function ($card) {
            return explode('-', $card)[1];
        }, $hand);

        return count(array_unique($suits)) === 1;
    }

    public function isStraight($hand)
    {
        $ranks = $this->getRanks($hand);
        return count($ranks) === 5
            && count(array_diff($ranks, array_values(range(min($ranks), max($ranks))))) === 0
            && count(array_unique($ranks)) === 5;
    }

    public function isThreeOfAKind($hand)
    {
        $rankCount = array_count_values($this->getRanks($hand));
        return in_array(3, $rankCount);
    }

    public function isTwoPair($hand)
    {
        $rankCount = array_count_values($this->getRanks($hand));
        return count(array_filter($rankCount, function ($count) {
            return $count === 2;
        })) === 2;
    }

    public function isPair($hand)
    {
        $rankCount = array_count_values($this->getRanks($hand));
        return in_array(2, $rankCount);
    }

    public function isHighCard($hand)
    {
        $ranks = $this->getRanks($hand);

        return count($ranks) === 5
            && count(array_diff($ranks, array_values(range(min($ranks), max($ranks))))) === 0
            && count(array_unique($ranks)) === 5;
    }
}
