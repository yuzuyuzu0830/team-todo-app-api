<?php

namespace App\Repositories;

class TodoRepository
{
    public function getAllByUserId(int $userId): array
    {
        return Todo::where('user_id', $userId)->get()->toArray();
    }
}
