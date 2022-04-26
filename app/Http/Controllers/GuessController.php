<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuessRequest;
use App\Http\Resources\GuessResource;
use App\Models\Attempt;
use App\Models\Game;
use App\Models\Guess;

class GuessController extends Controller
{
    /**
     * @param CreateGuessRequest $request
     * @param Game $game
     * @param Attempt $attempt
     * @return GuessResource
     */
    public function store(CreateGuessRequest $request, Game $game, Attempt $attempt): GuessResource
    {
        $guess = $attempt->guesses()->create($request->validated());

        return new GuessResource($guess);
    }
}
