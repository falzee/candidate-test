<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingPartRequest extends FormRequest
{
    public function authorize()
    {
        // Optionally, check ownership here later
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'building_part_type' => 'required|in:floor,wall,beam,column',
            'material_type' => ['required', 'string', function ($attribute, $value, $fail) {
                $partType = $this->input('building_part_type');
                $valid = false;

                if (in_array($partType, ['floor', 'wall']) && $value === 'CLT') {
                    $valid = true;
                } elseif ($partType === 'beam' && in_array($value, ['CLT', 'GLT'])) {
                    $valid = true;
                } elseif ($partType === 'column' && $value === 'GLT') {
                    $valid = true;
                }

                if (!$valid) {
                    $fail("The selected material_type is invalid for the building part type '{$partType}'.");
                }
            }],
            'supplier' => 'required|string|max:255',
        ];
    }
}

