<?php

namespace App\Services;

use App\Repositories\TodoRepositoryInterface;

class TodoService
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getTodosForUser(int $userId): array
    {
        return $this->todoRepository->getAllByUserId($userId);
    }
}
