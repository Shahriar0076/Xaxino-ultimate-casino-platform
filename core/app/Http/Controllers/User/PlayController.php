<?php

namespace App\Http\Controllers\User;

use App\Games\GamePlayer;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function playGame($alias, $isDemo = null)
    {
        $game      = Game::active()->where('alias', $alias)->firstOrFail();
        $pageTitle = "Play " . $game->name;
        $user = auth()->user();
        if ($isDemo) {
            abort_if($isDemo !== 'demo', 404);
        }
        $balance = ($isDemo === 'demo') ? @$user->demo_balance : @$user->balance;
        return view('Template::user.games.' . $alias, compact('game', 'pageTitle', 'isDemo', 'balance'));
    }

    public function investGame(Request $request, $alias, $isDemo = null)
    {
        $gamePlayer = new GamePlayer($alias, $isDemo);
        return $gamePlayer->startGame();
    }

    public function gameEnd(Request $request, $alias, $isDemo = null)
    {
        $gamePlayer = new GamePlayer($alias, $isDemo);
        return $gamePlayer->completeGame();
    }
}
