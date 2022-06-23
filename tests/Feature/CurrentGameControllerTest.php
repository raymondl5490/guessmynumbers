<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CurrentGameControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $defaultHeaders = [
        'Accept' => 'Application/Json',
    ];

    public function test_invoke()
    {
        Game::factory()->active()->create();

        $response = $this->get(route('games.current'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'number_one',
                'number_two',
                'number_three',
                'live_on',
                'author_name',
                'author_location',
                'author_email',
                'link',
                'link_title',
            ]
        ]);
    }
}
