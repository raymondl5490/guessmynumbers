<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuessResource;
use App\Models\Attempt;
use App\Models\Player;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AttemptGuessController extends Controller
{
    /**
     * @param Player $player
     * @param Attempt $attempt
     * @return AnonymousResourceCollection
     */
    public function index(Player $player, Attempt $attempt): AnonymousResourceCollection
    {
        return GuessResource::collection($attempt->guesses);
    }
}
