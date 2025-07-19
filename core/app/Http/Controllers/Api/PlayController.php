<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Games\GamePlayer;
use App\Models\GuessBonus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayController extends Controller
{
    public function playGame($alias, $isDemo = null)
    {
        $game = Game::active()->where('alias', $alias)->first();
        if (!$game) {
            $notify[] = 'Game not found';
            return responseError('not_found', $notify);
        }
        $user = auth()->user();
        if ($isDemo && $isDemo !== 'demo') {
            $notify[] = 'Invalid request';
            return responseError('not_found', $notify);
        }
        $balance = ($isDemo === 'demo') ? @$user->demo_balance : @$user->balance;

        $pokerImg           = null;
        $imagePath          = null;
        $winPercent         = [];
        $winChance          = null;
        $cardFindingImgName = [];
        $cardFindingImgPath = null;

        $gesBon = [];

        if ($game->alias == 'number_guess') {
            $gesBon = GuessBonus::where('alias', $game->alias)->get();
            foreach ($gesBon as $bon) {
                array_push($winPercent, $bon->percent);
                $winChance++;
            };
        }

        if ($game->alias == 'poker') {
            $gesBon = GuessBonus::where('alias', $game->alias)
                ->orderBy('chance', 'asc')
                ->pluck('percent')
                ->toArray();

            $pokerImg = [
                'royal_flush.png',
                'straight_flush.png',
                'four_kind.png',
                'full_house.png',
                'flash.png',
                'straight.png',
                'three_kind.png',
                'two_pair.png',
                'one_pair.png',
                'high_card.png',
            ];

            $imagePath = asset(activeTemplate(true) . 'images/poker');
        }

        if ($game->alias == 'card_finding') {
            $cardFindingImgPath = asset(activeTemplate(true) . 'images/play/cards');
            for ($i = 5; $i < 54; $i = $i + 5) {
                $cardFindingImgName[] = sprintf("%02d", $i);
            }
        }

        $notify[] = $game->name . ' game data';
        return responseSuccess('game_data', $notify, [
            'game'               => $game,
            'balance'        => showAmount($balance, currencyFormat: false),
            'imagePath'         => $imagePath,
            'winChance'          => $winChance,
            'winPercent'         => $winPercent,
            'gesBon'             => $gesBon,
            'pokerImg'           => $pokerImg,
            'shortDesc'          => ($game->alias == 'blackjack' ? $game->short_desc : null),
            'cardFindingImgName' => $cardFindingImgName,
            'cardFindingImgPath' => $cardFindingImgPath,
            'isDemo'             => $isDemo,
        ]);
    }

    public function investGame(Request $request, $alias, $isDemo = null)
    {
        $gamePlayer = new GamePlayer($alias, $isDemo, true);
        return $gamePlayer->startGame();
    }

    public function gameEnd(Request $request, $alias, $isDemo = null)
    {
        $gamePlayer = new GamePlayer($alias, $isDemo, true);
        return $gamePlayer->completeGame();
    }
}
