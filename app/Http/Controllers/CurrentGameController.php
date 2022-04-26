<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;

class CurrentGameController extends Controller
{
    /**
     * @return GameResource
     */
    public function __invoke(): GameResource
    {
        return new GameResource(Game::currentlyActive()->first());
    }
}
