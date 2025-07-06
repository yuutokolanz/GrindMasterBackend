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
            'match_date' => fake()->date(),
            'result' => fake()->randomElement(['Vitória'. 'Derrota', 'Empate']),
            'notes' => fake()->text(),
        ];
    }
}
