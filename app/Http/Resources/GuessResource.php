<?php

namespace App\Http\Resources;

use App\Models\Guess;
use Illuminate\Http\Resources\Json\JsonResource;

class GuessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        /** @var Guess|GuessResource $this */
        return [
            'id' => $this->id,
            'attempt_id' => $this->attempt_id,
            'number_one' => $this->number_one,
            'number_two' => $this->number_two,
            'number_three' => $this->number_three,
            'won' => $this->won,
        ];
    }
}
