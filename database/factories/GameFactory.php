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
            'author_name' => $this->faker->name(),
            'author_location' => $this->faker->country(),
            'author_email' => $this->faker->email(),
            'link' => $this->faker->url(),
            'link_title' => $this->faker->sentence(3),
            'game_start' => null,
            'game_end' => null,
        ];
    }

    /**
     * @return GameFactory
     */
    public function active(): GameFactory
    {
        return $this->state(function ($attributes) {
            $now = Carbon::now();
            if ($now->hour > 12) {
                $now->hour(12);
            } else {
                $now->hour(0);
            }

            return [
                'game_start' => $now,
                'game_end' => $now->copy()->addHours(12),
            ];
        });
    }
}
