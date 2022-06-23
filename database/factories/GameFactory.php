<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number_one' => $this->faker->numberBetween(0, 9),
            'number_two' => $this->faker->numberBetween(0, 9),
            'number_three' => $this->faker->numberBetween(0, 9),
            'live_on' => null,
            'author_name' => $this->faker->name(),
            'author_location' => $this->faker->country(),
            'author_email' => $this->faker->email(),
            'link' => $this->faker->url(),
            'link_title' => $this->faker->sentence(3),
        ];
    }

    /**
     * @return GameFactory
     */
    public function active(): GameFactory
    {
        return $this->state(function ($attributes) {
            return [
                'live_on' => Carbon::now('America/Los_Angeles'),
            ];
        });
    }
}
