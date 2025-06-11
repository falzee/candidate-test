<?php

namespace App\Services;

use App\Models\BuildingPart;
use App\Models\Project;
use App\Repositories\BuildingPartRepositoryInterface;

class BuildingPartService
{
    protected $repository;

    public function __construct(BuildingPartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createForProject(array $data, Project $project): BuildingPart
    {
        $data['project_id'] = $project->id;
        return $this->repository->create($data);
    }

    public function update(BuildingPart $buildingPart, array $data): bool
    {
        return $this->repository->update($buildingPart, $data);
    }

    public function delete(BuildingPart $buildingPart): bool
    {
        return $this->repository->delete($buildingPart);
    }
}
