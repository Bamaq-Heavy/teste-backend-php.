<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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



Route::resource('/user', UserController::class)->middleware('auth.jwt');

Route::post('/ping', function(){
    return response()->json(['status' => 'Success', 'Message' => 'Servidor Online'], 200);
});

Route::post('/auth', [AuthController::class, 'login']);

