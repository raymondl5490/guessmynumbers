<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GameController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return GameResource::collection(Game::all());
    }

    /**
     * @param Game $game
     * @return GameResource
     */
    public function show(Game $game): GameResource
    {
        return new GameResource($game);
    }

    /**
     * @param CreateGameRequest $gameRequest
     * @return GameResource
     */
    public function store(CreateGameRequest $gameRequest): GameResource
    {
        $game = new Game($gameRequest->validated());
        $game->save();

        return new GameResource($game);
    }

    /**
     * @param UpdateGameRequest $request
     * @param Game $game
     * @return Response
     */
    public function update(UpdateGameRequest $request, Game $game): Response
    {
        $game->fill($request->validated());
        $game->save();

        return response()->noContent();
    }

    /**
     * @param Game $game
     * @return Response
     */
    public function destroy(Game $game): Response
    {
        $game->delete();

        return response()->noContent();
    }
}
