<?php

namespace Tests\Feature;

use App\Models\Attempt;
use App\Models\Game;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AttemptControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $defaultHeaders = [
        'Accept' => 'Application/Json',
    ];

    public function test_store()
    {
        /** @var Game $game */
        $game = Game::factory()->create();
        $attemptArray = Attempt::factory()->raw([
            'game_id' => $game->id,
        ]);

        $response = $this->post(route('attempts.store', $game), $attemptArray);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'game_id',
                'won',
            ],
        ]);
    }
}
