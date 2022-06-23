<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $defaultHeaders = [
        'Accept' => 'Application/Json',
    ];

    public function test_index()
    {
        Game::factory(3)->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('games.index'));

        $response->assertOk();

        $response->assertJsonCount(3, 'data');
    }

    public function test_show()
    {
        $game = Game::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('games.show', $game));

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
            ],
        ]);
    }

    public function test_update()
    {
        $game = Game::factory()->create();

        $updatedAttributes = [
            'number_one' => 5,
            'number_two' => 4,
            'number_three' => 3,
            'live_on' => '2022-6-23 pm',
            'author_name' => 'Test User',
            'author_location' => 'USA',
            'author_email' => 'text@xyz.com',
            'link' => 'https://google.com',
            'link_title' => 'Google',
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch(route('games.update', $game), $updatedAttributes);

        $response->assertNoContent();

        $game->refresh();
        $this->assertEquals($game->only([
            'number_one',
            'number_two',
            'number_three',
            'live_on',
            'author_name',
            'author_location',
            'author_email',
            'link',
            'link_title',
        ]), $updatedAttributes);
    }

    public function test_store()
    {
        $gameArray = Game::factory()->raw();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertDatabaseCount('games', 0);

        $response = $this->post(route('games.store'), $gameArray);

        $response->assertCreated();

        $this->assertDatabaseCount('games', 1);

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
            ],
        ]);
    }

    public function test_destroy()
    {
        $game = Game::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('games.destroy', $game));

        $response->assertNoContent();
    }
}
