<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// End point for getting all the tasks
Route::get('/tasks', [TasksController::class, 'getAll']);

// End point for creating new task
Route::post('/tasks/new', [TasksController::class, 'addTask']);

// End point for updating a specific task (by id)
Route::post('/tasks/details/{id}', [TasksController::class, 'editTask']);

// End point for deleting a specific task (by id)
Route::delete('/tasks/{id}', [TasksController::class, 'deleteTask']);

// End point for updating the position of the tasks/reordering tasks
Route::put('/tasks/reorder', [TasksController::class, 'reorderTasks']);
