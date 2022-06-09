<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuessRequest;
use App\Http\Resources\GuessResource;
use App\Models\Attempt;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Player;

class GuessController extends Controller
{
    /**
     * @param CreateGuessRequest $request
     * @param Player $player
     * @param Attempt $attempt
     * @return GuessResource
     */
    public function store(CreateGuessRequest $request, Player $player, Attempt $attempt): GuessResource
    {
        $guess = $attempt->guesses()->create($request->validated());

        return new GuessResource($guess);
    }
}
