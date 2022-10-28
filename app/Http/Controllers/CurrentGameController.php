<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;
use Carbon\Carbon;

class CurrentGameController extends Controller
{
    /**
     * @return GameResource
     */
    public function __invoke(): GameResource
    {
        $current = Game::currentlyActive()->first();
        if (!$current) {
            $game = new Game;
            $game->number_one = 3;
            $game->number_two = 2;
            $game->number_three = 2;
            $game->author_name = "Smart";
            $game->author_email = "smartdev0322@gmail.com";
            $game->author_location = "CA";
            $game->live_on = Carbon::now('America/Los_Angeles')->format('Y-m-d a');
            $game->save();
        }
        return new GameResource($current);
    }
}
