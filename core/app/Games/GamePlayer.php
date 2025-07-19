<?php

namespace App\Games;

use Exception;

class GamePlayer
{
    private $games = [
        'head_tail'           => HeadTail::class,
        'rock_paper_scissors' => RockPaperScissors::class,
        'spin_wheel'          => SpinWheel::class,
        'number_guess'        => NumberGuess::class,
        'dice_rolling'        => DiceRolling::class,
        'card_finding'        => CardFinding::class,
        'number_slot'         => NumberSlot::class,
        'number_pool'         => PoolNumber::class,
        'roulette'            => Roulette::class,
        'casino_dice'         => CasinoDice::class,
        'keno'                => Keno::class,
        'blackjack'           => BlackJack::class,
        'mines'               => Mines::class,
        'poker'               => Poker::class,
        'color_prediction'    => ColorPrediction::class,
        'crazy_times'         => CrazyTimes::class,
        'dream_catcher'       => DreamCatcher::class,
        'andar_bahar'         => AndarBahar::class
    ];

    private $playingGame;
    private $isDemo;
    private $fromApi;

    public function __construct($alias, $isDemo, $fromApi = false)
    {
        $this->playingGame = $alias;
        $this->isDemo = $isDemo;
        $this->fromApi = $fromApi;
    }

    public function startGame()
    {
        $gameName = $this->playingGame;
        try {
            $gameClass = $this->games[$gameName];
        } catch (\Exception $e) {
            if ($this->fromApi) {
                $notify[] = "The game $gameName not found";
                return responseError('not_found', $notify);
            }
            throw new Exception("The game $gameName not found");
        }
        $instance = new $gameClass;
        $instance->demoPlay = $this->isDemo ? true : false;
        $instance->fromApi = $this->fromApi ?? false;
        return $instance->play();
    }

    public function completeGame()
    {
        $gameName = $this->playingGame;
        try {
            $gameClass = $this->games[$gameName];
        } catch (\Exception $e) {
            if ($this->fromApi) {
                $notify[] = "The game $gameName not found";
                return responseError('not_found', $notify);
            }
            throw new Exception("The game $gameName not found");
        }
        $instance = new $gameClass;
        $instance->demoPlay = $this->isDemo ? true : false;
        $instance->fromApi = $this->fromApi ?? false;
        return $instance->complete();
    }
}
