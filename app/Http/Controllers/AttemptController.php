<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttemptRequest;
use App\Http\Resources\AttemptResource;
use App\Models\Attempt;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class AttemptController extends Controller
{
    /**
     * @param CreateAttemptRequest $request
     * @param Player $player
     * @return AttemptResource
     */
    public function store(CreateAttemptRequest $request, Player $player): AttemptResource
    {
        /** @var Attempt $attempt */
        $attempt = $player->attempts()->create($request->validated());

        return new AttemptResource($attempt);
    }

    /**
     * @param $id
     * @return AttemptResource
     */
    public function win($id): AttemptResource
    {
        $attempt = Attempt::find($id);
        $attempt->won = 1;
        $attempt->save();
        return new AttemptResource($attempt);
    }

    /**
     * @param $id
     * @return AttemptResource
     */
    public function hasSubmittedVipGame($id): AttemptResource
    {
        $attempt = Attempt::find($id);
        $attempt->has_submitted_vip_game = 1;
        $attempt->save();
        return new AttemptResource($attempt);
    }

    /**
     * Return overall number_of_attempts and number_of_wins
     * 
     * @return JsonResponse
     */
    public function overallStatistics(): JsonResponse
    {
        $numberOfAttempts = Attempt::whereNotNull('game_id')->count();
        $numberOfWons = Attempt::where('won', 1)->count();
        return response()->json([
            'number_of_attempts' => $numberOfAttempts,
            'number_of_wons' => $numberOfWons,
        ]);
    }

}
