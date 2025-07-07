<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contest>
 */
class ContestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'game_id' => \App\Models\Game::factory(),
            'contest_date' => fake()->date(),
            'result' => fake()->randomElement(['Victory', 'Defeat', 'Draw']),
            'notes' => fake()->text(),
        ];
    }
}
