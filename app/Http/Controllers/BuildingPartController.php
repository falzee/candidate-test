<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingPartRequest;
use App\Models\BuildingPart;
use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BuildingPartController extends Controller
{
    use AuthorizesRequests;
    public function create(Project $project)
    {
        $this->authorize('update', $project);

        $suppliers = Http::get(url('/api/suppliers'))->json();
        return view('project.show', compact('project', 'suppliers'));
    }

    public function store(BuildingPartRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validated();
        $validated['project_id'] = $project->id;

        BuildingPart::create($validated);

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

        $buildingPart->update($request->validated());

        return redirect()->route('project.show', $project)->with('success', 'Building part updated successfully.');
    }

    public function destroy(Project $project, BuildingPart $buildingPart)
    {
        $this->authorize('update', $project);
        $buildingPart->loadMissing('project');
        $this->authorize('delete', $buildingPart);

        $buildingPart->delete();

        return redirect()->route('project.show', $project)->with('success', 'Building part deleted.');
    }
}
