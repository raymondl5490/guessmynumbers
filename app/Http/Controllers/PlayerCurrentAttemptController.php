<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttemptResource;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerCurrentAttemptController extends Controller
{
    /**
     * @param Player $player
     * @return AttemptResource
     */
    public function __invoke(Player $player): AttemptResource
    {
        $currentAttempt = $player->attempts()->where('game_id', Game::currentlyActive()->first()->id)->first();
        return new AttemptResource($currentAttempt);
    }
}
