<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            // Se as credenciais forem inválidas, retornar erro 401
            return response()->json(['status' => 'error', 'message' => 'Credenciais inválidas'], Response::HTTP_UNAUTHORIZED);
        }

        // Obter o usuário autenticado
        $user = JWTAuth::user();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Usuário autenticado com sucesso',
            'token' => $token,
            'expires' => JWTAuth::factory()->getTTL() * 60, // Tempo de expiração do token em segundos
            'tokenmsg' => 'Use o token para acessar os endpoints!',
            'user' => $user
        ], Response::HTTP_OK);
    }
}
