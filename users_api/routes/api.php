<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::post('/ping', function () {
    return response()->json(['message' => 'pong']);
});

//Para gerar um token de segurança de sessão, chame a seguinte rota...
Route::get('/token', function (Request $request) {
    $token = csrf_token();
});

Route::post('/auth', [AuthController::class, 'login']);

Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::get('/user/{id}', [UserController::class, 'get']);
Route::get('/user', [UserController::class, 'index']);



