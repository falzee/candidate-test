<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\BuildingPart;
use App\Policies\ProjectPolicy;
use App\Policies\BuildingPartPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
        BuildingPart::class => BuildingPartPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
