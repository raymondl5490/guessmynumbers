<?php

namespace Tests\Feature;

use App\Models\Attempt;
use App\Models\Guess;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GuessControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $defaultHeaders = [
        'Accept' => 'Application/Json',
    ];

    public function test_store()
    {
        /** @var Attempt $attempt */
        $attempt = Attempt::factory()->create();
        $guessArray = Guess::factory()->raw([
            'attempt_id' => $attempt->id,
        ]);

        $this->assertDatabaseCount('guesses', 0);

        $response = $this->post(route('guesses.store', ['game' => $attempt->game, 'attempt' => $attempt]), $guessArray);

        $response->assertCreated();

        $this->assertDatabaseCount('guesses', 1);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'attempt_id',
                'number_one',
                'number_two',
                'number_three',
                'won',
            ],
        ]);

    }
}
