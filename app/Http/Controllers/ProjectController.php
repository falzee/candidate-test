<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class ProjectController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('project.index', compact('projects'));
    }

    public function create()
    {
        return view('project.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('project.show', $project)
                         ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $project->load('buildingParts');
        $buildingParts = $project->buildingParts()->orderBy('created_at', 'desc')->paginate(5);

        return view('project.show', compact('project', 'buildingParts'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->only('name', 'description'));

        return redirect()->route('project.show', $project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->buildingParts()->delete(); // cascade delete
        $project->delete();
        return redirect()->route('project.index');
    }
}