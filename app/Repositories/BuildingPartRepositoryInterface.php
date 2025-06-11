<?php

namespace App\Repositories;

use App\Models\BuildingPart;

interface BuildingPartRepositoryInterface
{
    public function create(array $data): BuildingPart;
    public function update(BuildingPart $buildingPart, array $data): bool;
    public function delete(BuildingPart $buildingPart): bool;
}
