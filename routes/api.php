<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\TimesheetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('timesheet', TimesheetController::class);
    Route::post('timesheet/{id}', [TimesheetController::class, 'update']);
    Route::resource('project', ProjectController::class);
    Route::post('project/{id}', [ProjectController::class, 'update']);
    Route::resource('user', UserController::class);
    Route::post('user/{id}', [UserController::class, 'update']);

    Route::get('logout', [AuthController::class, 'logout']);
});


