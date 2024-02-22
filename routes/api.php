<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PingController;
use App\Http\Controllers\Api\AuthController;

Route::post('/ping', [PingController::class, 'ping']);

Route::post('/auth', [AuthController::class, 'authenticate']);

// Rotas protegidas que exigem autenticação
Route::middleware('auth:api')->group(function () {
    // Rotas para usuários
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
    Route::get('/user/{id}', [UserController::class, 'show']);
});