<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByUser(int $userId): LengthAwarePaginator
    {
        return Project::where('user_id', $userId)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    public function delete(Project $project): bool
    {
        $project->buildingParts()->delete(); // cascade delete
        return $project->delete();
    }
}
