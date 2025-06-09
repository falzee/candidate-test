<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building_part_type',
        'material_type',
        'supplier',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}