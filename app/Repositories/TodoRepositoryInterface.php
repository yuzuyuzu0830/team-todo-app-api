<?php

namespace App\Repositories;

use App\Models\Todo;

interface TodoRepositoryInterface
{
    public function getAllByTeamId(int $teamId): array;

    public function create(array $data): Todo;
}
