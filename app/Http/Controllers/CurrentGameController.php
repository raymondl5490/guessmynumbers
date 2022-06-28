<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Attempt;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class CurrentGameController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $activeGame = Game::currentlyActive()->first();
        $numberOfAttempts = Attempt::where('game_id', $activeGame->id)
            ->count();
        $numberOfWons = Attempt::where('game_id', $activeGame->id)
            ->where('won', 1)
            ->count();

        $activeGameJson = (new GameResource($activeGame))->jsonSerialize();
        $activeGameJson['number_of_attempts'] = $numberOfAttempts;
        $activeGameJson['number_of_wons'] = $numberOfWons;

        return response()->json($activeGameJson);
    }
}
