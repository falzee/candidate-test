<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingPartRequest;
use App\Models\BuildingPart;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BuildingPartController extends Controller
{
    // public function index(Project $project)
    // {
    //     $this->authorizeProject($project);

    //     $buildingParts = $project->buildingParts()->paginate(10);
    //     return view('building-part.index', compact('project', 'buildingParts'));
    // }

    public function create(Project $project)
    {
        $this->authorizeProject($project);

        $suppliers = Http::get(url('/api/suppliers'))->json();
        return view('project.show', compact('project', 'suppliers'));
    }

    public function store(BuildingPartRequest $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validated();
        $validated['project_id'] = $project->id;

        BuildingPart::create($validated);

        return redirect()->route('project.show', $project)->with('success', 'Building part created successfully.');
    }

    public function edit(Project $project, BuildingPart $buildingPart)
    {
        $this->authorizeProject($project);
        $this->authorizeBuildingPart($buildingPart, $project);

        $suppliers = Http::get(url('/api/suppliers'))->json();
        return view('project.show', compact('project', 'buildingPart', 'suppliers'));
    }

    public function update(BuildingPartRequest $request, Project $project, BuildingPart $buildingPart)
    {
        $this->authorizeProject($project);
        $this->authorizeBuildingPart($buildingPart, $project);

        $buildingPart->update($request->validated());

        return redirect()->route('project.show', $project)->with('success', 'Building part updated successfully.');
    }

    public function destroy(Project $project, BuildingPart $buildingPart)
    {
        $this->authorizeProject($project);
        $this->authorizeBuildingPart($buildingPart, $project);

        $buildingPart->delete();

        return redirect()->route('project.show', $project)->with('success', 'Building part deleted.');
    }

    // Helper: check that authenticated user owns the project
    protected function authorizeProject(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }
    }

    // Helper: check building part belongs to project
    protected function authorizeBuildingPart(BuildingPart $buildingPart, Project $project)
    {
        if ($buildingPart->project_id !== $project->id) {
            abort(403);
        }
    }
}
