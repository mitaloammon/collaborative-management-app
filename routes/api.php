<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('projects', ProjectController::class);
        Route::post('projects/{project}/members', [ProjectController::class, 'addMember']);
        Route::delete('projects/{project}/members/{user}', [ProjectController::class, 'removeMember']);

        Route::apiResource('projects.tasks', TaskController::class)->shallow();

        Route::apiResource('tasks.comments', CommentController::class)->shallow();

        Route::apiResource('tags', TagController::class);
        Route::post('tasks/{task}/tags/{tag}', [TagController::class, 'attachToTask']);
        Route::delete('tasks/{task}/tags/{tag}', [TagController::class, 'detachFromTask']);
    });
});