<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->has('date_of_birth')) {
            $query->where('date_of_birth', $request->date_of_birth);
        }
        $users = $query->get();

        return response()->json($users, 200);
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(["user" => $user]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }
    }

    public function store(UserCreateRequest $request)
    {
        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->toArray());

        return response()->json($user, 201);
    }


    public function update($id,UserUpdateRequest $request)
    {
        try {
            $user = User::findOrFail($id);
            if (isset($request['password'])) {
                $request['password'] = Hash::make($request['password']);
            }
            $user->update($request->toArray());
            return response()->json(["user" => $user]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }

    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->timesheets()->delete();
            $user->delete();
            return response()->json(['message' => 'User and related timesheets deleted'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }

    }
}
