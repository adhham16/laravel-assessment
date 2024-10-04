<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetCreateRequest;
use App\Http\Requests\TimesheetUpdateRequest;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {
        return response()->json(["timesheet" => Timesheet::all()]);
    }

    public function show($id)
    {
        return response()->json(["timesheet" => Timesheet::findOrFail($id)]);
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
        $timesheet = Timesheet::findOrFail($id);

        $timesheet->update($request->toArray());
        $project = Project::find($timesheet->project_id);
        $user = User::find($timesheet->user_id);
        $project->users()->syncWithoutDetaching($user->id);
        return response()->json(["message" => "Timesheet updated successfully","timesheet" =>$timesheet], 200);
    }

    public function destroy($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();

        return response()->json(['message' => 'Timesheet deleted successfully'], 200);
    }
}
