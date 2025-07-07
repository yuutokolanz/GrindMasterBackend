<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CsStat>
 */
class CsStatFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'contest_id' => \App\Models\Contest::factory(),
      'map_played' => fake()->randomElement(['de_dust2', 'de_mirage', 'de_inferno', 'de_cache', 'de_overpass']),
      'kills' => fake()->numberBetween(5, 35),
      'deaths' => fake()->numberBetween(5, 25),
      'hs_percent' => fake()->randomFloat(2, 10, 90),
      'mvps' => fake()->numberBetween(0, 8),
    ];
  }
}
