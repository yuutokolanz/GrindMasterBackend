<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LolStat>
 */
class LolStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'champion_played' => fake()->name(),
            'kills' => fake()->numberBetween(0, 100),
            'deaths' => fake()->numberBetween(0, 100),
            'assists' => fake()->numberBetween(0, 100),
            'cs' => fake()->numberBetween(0, 500),
        ];
    }
}
