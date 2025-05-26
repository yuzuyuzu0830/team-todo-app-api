<?php

namespace App\Repositories;

interface TodoRepositoryInterface
{
    public function getAllByUserId(int $userId): array;
}
