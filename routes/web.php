<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BuildingPartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
    Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

    // Route::get('/project/{project}/building-part', [BuildingPartController::class, 'index'])->name('building-part.index');
    Route::get('/project/{project}/building-part/create', [BuildingPartController::class, 'create'])->name('building-part.create');
    Route::post('/project/{project}/building-part', [BuildingPartController::class, 'store'])->name('building-part.store');
    Route::get('/project/{project}/building-part/{buildingPart}/edit', [BuildingPartController::class, 'edit'])->name('building-part.edit');
    Route::put('/project/{project}/building-part/{buildingPart}', [BuildingPartController::class, 'update'])->name('building-part.update');
    Route::delete('/project/{project}/building-part/{buildingPart}', [BuildingPartController::class, 'destroy'])->name('building-part.destroy');
    // Route::delete('/building-parts/{id}', [BuildingPartController::class, 'destroy'])->name('building-parts.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';