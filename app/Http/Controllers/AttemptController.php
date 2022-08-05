<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
     * Return overall number_of_attempts and number_of_wons
     * 
     * @return JsonResponse
     */
    public function overallStatistics(): JsonResponse
    {
        $numberOfCompletedAttempts = DB::table('attempts')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->selectRaw('count(guesses.id) as number_of_guesses')
                        ->from('guesses')
                        ->whereColumn('guesses.attempt_id', 'attempts.id')
                        ->groupBy('attempt_id')
                        ->limit(1);
                }, '>=', 3)
                ->orWhere('won', 1);
            })
            ->count();
        $numberOfWons = Attempt::where('won', 1)->count();
        return response()->json([
            'number_of_attempts' => $numberOfCompletedAttempts,
            'number_of_wons' => $numberOfWons,
        ]);
    }

}
