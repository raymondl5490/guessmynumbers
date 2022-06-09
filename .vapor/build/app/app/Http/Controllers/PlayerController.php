<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * @param Player $player
     * @return PlayerResource
     */
    public function show(Player $player): PlayerResource
    {
        return new PlayerResource($player);
    }

    /**
     * @return PlayerResource
     */
    public function store(): PlayerResource
    {
        $player = new Player();
        $player->save();

        return new PlayerResource($player);
    }
}
