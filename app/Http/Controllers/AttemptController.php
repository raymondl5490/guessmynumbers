<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttemptRequest;
use App\Http\Resources\AttemptResource;
use App\Models\Attempt;
use App\Models\Game;
use App\Models\Player;

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
}
