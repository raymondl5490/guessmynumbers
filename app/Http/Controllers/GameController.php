<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

function nextLiveOn($current) {
    if (substr($current, 11) == 'am') {
        return substr($current, 0, -2) . 'pm';
    } else {
        $str = substr($current, 0, -3);
        $dt = Carbon::createFromFormat('Y-m-d', $str);
        return $dt->addDay()->format('Y-m-d') . ' am';
    }
}

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
     * @return AnonymousResourceCollection
     */
    public function submitted(): AnonymousResourceCollection
    {
        $submittedGames = Game::whereNull('live_on')
                ->orderBy('created_at', 'desc')
                ->get();
        return GameResource::collection($submittedGames);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function queued(): AnonymousResourceCollection
    {
        $now = Carbon::now('America/Los_Angeles')->format('Y-m-d a');
        $queuedGames = Game::where('live_on', '>', $now)
                ->orderBy('live_on', 'desc')
                ->get();
        return GameResource::collection($queuedGames);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function finished(): AnonymousResourceCollection
    {
        $now = Carbon::now('America/Los_Angeles')->format('Y-m-d a');
        $finishedGames = Game::where('live_on', '<', $now)
                ->orderBy('live_on', 'desc')
                ->get();
        return GameResource::collection($finishedGames);
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
     * @param $id
     * @return GameResource
     */
    public function approve($id): GameResource
    {
        $now = Carbon::now('America/Los_Angeles')->format('Y-m-d a');

        $queuedGames = Game::where('live_on', '>=', $now)->get();
        $queuedLiveOns = [];
        foreach ($queuedGames as $queuedGame) {
            array_push($queuedLiveOns, $queuedGame->live_on);
        }

        $availableLiveOn = $now;
        while (in_array($availableLiveOn, $queuedLiveOns)) {
            $availableLiveOn = nextLiveOn($availableLiveOn);
        }

        $game = Game::find($id);
        $game->live_on = $availableLiveOn;

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
