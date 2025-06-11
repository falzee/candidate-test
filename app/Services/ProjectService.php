<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;

class ProjectService
{
    protected $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listUserProjects(int $userId)
    {
        return $this->repository->getAllByUser($userId);
    }

    public function createProject(array $data): Project
    {
        return $this->repository->create($data);
    }

    public function updateProject(Project $project, array $data): bool
    {
        return $this->repository->update($project, $data);
    }

    public function deleteProject(Project $project): bool
    {
        return $this->repository->delete($project);
    }
}
