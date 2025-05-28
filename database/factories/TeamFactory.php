<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            // チーム名を2文字で作成する
            'name' => implode(' ', $this->faker->words(2))
        ];
    }
} 