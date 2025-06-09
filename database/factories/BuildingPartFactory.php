<?php

namespace Database\Factories;

// database/factories/BuildingPartFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingPartFactory extends Factory
{
    protected $model = \App\Models\BuildingPart::class;

    public function definition()
    {
        $types = ['floor', 'wall', 'beam', 'column'];
        $type = $this->faker->randomElement($types);

        // Apply material type rules for dummy data:
        if (in_array($type, ['floor', 'wall'])) {
            $material = 'CLT';
        } elseif ($type === 'beam') {
            $material = $this->faker->randomElement(['CLT', 'GLT']);
        } else { // column
            $material = 'GLT';
        }

        $suppliers = ['Xlam', 'CUSP', 'Kalvasta Timber', 'Timberlink'];
        $supplier = $this->faker->randomElement($suppliers);

        return [
            'name' => $this->faker->word,
            'building_part_type' => $type,
            'material_type' => $material,
            'supplier' => $supplier,
        ];
    }
}

