<?php

namespace Database\Factories;

use App\Models\Attempt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guess>
 */
class GuessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'row' => $this->faker->numberBetween(1, 3),
            'attempt_id' => Attempt::factory()->create()->id,
            'number_one' => $this->faker->numberBetween(0, 9),
            'number_two' => $this->faker->numberBetween(0, 9),
            'number_three' => $this->faker->numberBetween(0, 9),
        ];
    }
}
