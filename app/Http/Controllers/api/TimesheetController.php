<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetCreateRequest;
use App\Http\Requests\TimesheetUpdateRequest;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {
        return response()->json(["timesheet" => Timesheet::all()]);
    }

    public function show($id)
    {
        try {
            $timesheet = Timesheet::findOrFail($id);
            return response()->json(["timesheet" => $timesheet]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Timesheet not found'
            ], 404);
        }
    }

    public function store(TimesheetCreateRequest $request)
    {
        $timesheet = Timesheet::create($request->toArray());
        $project = Project::find($timesheet->project_id);
        $user = User::find($timesheet->user_id);
        $project->users()->syncWithoutDetaching($user->id);
        return response()->json(["message" => "Timesheet created successfully","timesheet" => $timesheet], 201);
    }

    public function update($id,TimesheetUpdateRequest $request)
    {
        try {
            $timesheet = Timesheet::findOrFail($id);

            $timesheet->update($request->toArray());
            $project = Project::find($timesheet->project_id);
            $user = User::find($timesheet->user_id);
            $project->users()->syncWithoutDetaching($user->id);
            return response()->json(["message" => "Timesheet updated successfully","timesheet" =>$timesheet], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Timesheet not found'
            ], 404);
        }

    }

    public function destroy($id)
    {
        try {
            $timesheet = Timesheet::findOrFail($id);
            $timesheet->delete();

            return response()->json(['message' => 'Timesheet deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Timesheet not found'
            ], 404);
        }

    }
}
