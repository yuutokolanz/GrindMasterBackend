<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
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
            'title' => fake()->sentence(3),
            'description' => fake()->text(),
            'repeatable' => fake()->boolean(),
            'completed_count' => fake()->numberBetween(0, 10),
        ];
    }
}
