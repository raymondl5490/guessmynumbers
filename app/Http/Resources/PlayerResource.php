<?php

namespace App\Http\Resources;

use App\Models\Player;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Player|PlayerResource $this */
        return [
            'id' => $this->id,
            'attempts' => AttemptResource::collection($this->attempts),
            'number_of_attempts' => $this->number_of_attempts,
            'number_of_wons' => $this->number_of_wons,
        ];
    }
}
