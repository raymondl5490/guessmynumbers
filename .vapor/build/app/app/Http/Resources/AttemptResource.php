<?php

namespace App\Http\Resources;

use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Attempt|AttemptResource $this */
        return [
            'id' => $this->id,
            'player_id' => $this->player_id,
            'game_id' => $this->game_id,
            'guesses' => GuessResource::collection($this->guesses),
            'won' => $this->won,
        ];
    }
}
