<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::patch('tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('api.tasks.toggle-status');
    Route::apiResource('tasks', TaskController::class)->names('api.tasks');
});
