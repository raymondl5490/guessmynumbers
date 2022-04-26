<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttemptResource;
use App\Models\Game;

class AttemptController extends Controller
{
    /**
     * @param Game $game
     * @return AttemptResource
     */
    public function store(Game $game): AttemptResource
    {
        $attempt = $game->attempts()->create();

        return new AttemptResource($attempt);
    }
}
