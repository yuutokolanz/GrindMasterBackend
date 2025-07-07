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
        $champions = ['Jinx', 'Ashe', 'Ezreal', 'Vayne', 'Caitlyn', 'Lucian', 'Sivir', 'Tristana'];
        $champion = fake()->randomElement($champions);

        return [
            'contest_id' => \App\Models\Contest::factory(),
            'champion_played' => $champion,
            'champion_played_icon' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/tiles/' . $champion . '_0.jpg',
            'kills' => fake()->numberBetween(0, 30),
            'deaths' => fake()->numberBetween(0, 15),
            'assists' => fake()->numberBetween(0, 25),
            'cs' => fake()->numberBetween(50, 300),
        ];
    }
}
