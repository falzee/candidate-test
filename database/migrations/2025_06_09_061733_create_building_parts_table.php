<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('building_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            $table->string('name');
            // $table->enum('building_part_type', ['floor', 'wall', 'beam', 'column']);
            // $table->enum('material_type', ['CLT', 'GLT']);
            $table->string('building_part_type'); // store as string
            $table->string('material_type'); // store as string
            $table->string('supplier');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_parts');
    }
};
