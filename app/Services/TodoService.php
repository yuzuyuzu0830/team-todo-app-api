<?php

namespace App\Services;

use App\Repositories\TodoRepositoryInterface;

class TodoService
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {
    }

    public function getTodosForUser(int $teamId): array
    {
        return $this->todoRepository->getAllByTeamId($teamId);
    }

    public function createTodo(array $data): array
    {
        return $this->todoRepository->create($data)->toArray();
    }
}
