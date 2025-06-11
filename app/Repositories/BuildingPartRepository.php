<?php

namespace App\Repositories;

use App\Models\BuildingPart;

class BuildingPartRepository implements BuildingPartRepositoryInterface
{
    public function create(array $data): BuildingPart
    {
        return BuildingPart::create($data);
    }

    public function update(BuildingPart $buildingPart, array $data): bool
    {
        return $buildingPart->update($data);
    }

    public function delete(BuildingPart $buildingPart): bool
    {
        return $buildingPart->delete();
    }
}
