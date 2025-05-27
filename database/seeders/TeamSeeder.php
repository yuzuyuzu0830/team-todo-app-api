<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::create(['name' => 'Test Team']);

        $user = User::create([
            'name' => 'Yuzuka',
            'email' => 'yuzuka@example.com',
            'password' => bcrypt('password'),
            'team_id' => $team->id,
        ]);

        $team->users()->attach($user->id, ['role' => 'admin']);
    }
}
