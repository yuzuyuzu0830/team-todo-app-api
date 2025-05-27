<?php

namespace App\Repositories;

interface TodoRepositoryInterface
{
    public function getAllByTeamId(int $teamId): array;

    public function create(array $data): object;
}
