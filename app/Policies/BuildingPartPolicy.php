<?php

namespace App\Policies;

use App\Models\BuildingPart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BuildingPartPolicy
{
    /**
     * Determine whether the user can view the building part.
     */
    public function view(User $user, BuildingPart $buildingPart): bool
    {
        return $user->id === $buildingPart->project->user_id;
    }

    /**
     * Determine whether the user can create a building part.
     * This is usually handled via the related project authorization.
     */
    public function create(User $user): bool
    {
        // You may want to restrict this in ProjectPolicy instead.
        return true;
    }

    /**
     * Determine whether the user can update the building part.
     */
    public function update(User $user, BuildingPart $buildingPart): bool
    {
        return $user->id === $buildingPart->project->user_id;
    }

    /**
     * Determine whether the user can delete the building part.
     */
    public function delete(User $user, BuildingPart $buildingPart): bool
    {
        return $user->id === $buildingPart->project->user_id;
    }
}
