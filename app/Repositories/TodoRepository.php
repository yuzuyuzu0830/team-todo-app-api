<?php

namespace App\Repositories;

use App\Models\Todo;
use App\Enums\TodoStatus;

class TodoRepository implements TodoRepositoryInterface
{
    public function getAllByTeamId(int $teamId): array
    {
        return Todo::where('team_id', $teamId)->get()->toArray();
    }

    public function create(array $data): Todo
    {
        return Todo::create([
            'team_id' => $data['team_id'],
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'completed' => TodoStatus::Pending
        ]);
    }
}
