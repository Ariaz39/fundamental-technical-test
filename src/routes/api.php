<?php

use App\Http\Controllers\AuthController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    // Ruta adicional de prueba
    Route::get('/test', function () {
        return response()->json(Task::all());
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
