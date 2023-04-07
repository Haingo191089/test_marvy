<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Game;
use App\Models\Score;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();
        $games = Game::factory()->count(10)->create();
        for ($i = 0; $i < 10; $i++) {{
            $scores = Score::factory()->for($users->random())->for($games->random())->create();
        }}
        
    }
}
