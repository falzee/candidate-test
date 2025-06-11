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

        $suppliers = ['Xlam', 'Sodra', 'Kalvasta Timber', 'Timberlink', 'KLH'];
        $suppliersClt = ['Xlam', 'Sodra', 'KLH'];
        $suppliersGlt = ['Kalvasta Timber', 'Timberlink'];
        // Apply material type rules for dummy data:
        if (in_array($type, ['floor', 'wall'])) {
            $material = 'CLT';
            $supplier = $this->faker->randomElement($suppliersClt);
        } elseif ($type === 'beam') {
            $material = $this->faker->randomElement(['CLT', 'GLT']);
            $supplier = $this->faker->randomElement($suppliers);
        } else { // column
            $material = 'GLT';
            $supplier = $this->faker->randomElement($suppliersGlt);
        }


        return [
            'name' => $this->faker->word,
            'building_part_type' => $type,
            'material_type' => $material,
            'supplier' => $supplier,
        ];
    }
}

