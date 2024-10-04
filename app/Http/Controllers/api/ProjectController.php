<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(["projects" => Project::all()]);
    }

    public function show($id)
    {
        return response()->json(["project" => Project::find($id) ?? null]);
    }

    public function store(ProjectCreateRequest $request)
    {
        $project = Project::create($request->toArray());

        return response()->json(["message" => "Project created successfully","project" => $project], 201);
    }

    public function update($id,ProjectUpdateRequest $request)
    {
        $project = Project::findOrFail($id);

        $project->update($request->toArray());

        return response()->json(["message" => "Project updated successfully","project" =>$project], 200);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
