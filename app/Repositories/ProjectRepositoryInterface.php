<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function getAllByUser(int $userId): LengthAwarePaginator;
    public function create(array $data): Project;
    public function update(Project $project, array $data): bool;
    public function delete(Project $project): bool;
}
