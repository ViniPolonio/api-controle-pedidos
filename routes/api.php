<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rota pública para criar usuário (sem Sanctum)
Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('montink/v1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); 
    Route::apiResource('users', UserController::class)->except(['store']);
});
