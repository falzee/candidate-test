<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingPartRequest;
use App\Models\BuildingPart;
use App\Models\Project;
use App\Services\BuildingPartService;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// [Controller]  --uses-->  [Service]  --uses-->  [Repository]  --uses-->  [Model]
// validate & auth > data manipulation > only db related operations


class BuildingPartController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(BuildingPartService $service)
    {
        $this->service = $service;
    }

    public function create(Project $project)
    {
        $this->authorize('update', $project);

        $suppliers = Http::get(url('/api/suppliers'))->json();
        return view('project.show', compact('project', 'suppliers'));
    }

    public function store(BuildingPartRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $this->service->createForProject($request->validated(), $project);

        return redirect()->route('project.show', $project)->with('success', 'Building part created successfully.');
    }

    public function edit(Project $project, BuildingPart $buildingPart)
    {
        $this->authorize('update', $project);
        $buildingPart->loadMissing('project');
        $this->authorize('update', $buildingPart);

        $suppliers = Http::get(url('/api/suppliers'))->json();
        return view('project.show', compact('project', 'buildingPart', 'suppliers'));
    }

    public function update(BuildingPartRequest $request, Project $project, BuildingPart $buildingPart)
    {
        $this->authorize('update', $project);
        $buildingPart->loadMissing('project');
        $this->authorize('update', $buildingPart);

        $this->service->update($buildingPart, $request->validated());

        return redirect()->route('project.show', $project)->with('success', 'Building part updated successfully.');
    }

    public function destroy(Project $project, BuildingPart $buildingPart)
    {
        $this->authorize('update', $project);
        $buildingPart->loadMissing('project');
        $this->authorize('delete', $buildingPart);

        $this->service->delete($buildingPart);

        return redirect()->route('project.show', $project)->with('success', 'Building part deleted.');
    }
}
