<?php

namespace Database\Factories;

// database/factories/ProjectFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = \App\Models\Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'user_id' => 2, // or use factory for User if you want
        ];
    }
}


