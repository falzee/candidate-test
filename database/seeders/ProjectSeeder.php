<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\BuildingPart;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::factory()
            ->count(5)
            ->has(BuildingPart::factory()->count(3))  // each project has 3 building parts
            ->create();
    }
}

