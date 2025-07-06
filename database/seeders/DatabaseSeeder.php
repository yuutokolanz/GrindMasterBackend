<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->seedGames();
    }

    public function seedGames(): void {
        $games = [
            ['name' => 'LeagueOfLegends', 'icon_url' => 'https://static.wikia.nocookie.net/leagueoflegends/images/0/07/League_of_Legends_icon.png/revision/latest?cb=20191018194326'],
            ['name' => 'CS2', 'icon_url' => 'https://cdn2.steamgriddb.com/icon/fe772ff1261b820e437821342b445539/32/256x256.png'],
        ];
        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
