<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/auth', [AuthController::class, 'authenticate']); //Login

Route::post('/ping', [PingController::class, 'ping']); //Testar API


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/users', [UserController::class, 'index']); //Listar todos os Usuários
    Route::post('/users', [UserController::class, 'store']); //Cadastrar Usuário
    Route::delete('/users/{id}', [UserController::class, 'destroy']); //Deletar todos os Usuários
    Route::get('/users/{id}', [UserController::class, 'show']); //Listar todos os Usuários buscando pelo ID
    Route::put('/users/{id}', [UserController::class, 'update']); //Update dos dados do usuário    
});
