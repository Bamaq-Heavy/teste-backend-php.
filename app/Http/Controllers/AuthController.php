<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash; 
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Erro ao criar token'], 500);
        }
    
        $user = auth()->user();
    
        $expires = Carbon::now()->addMinutes(auth('api')->factory()->getTTL())->toDateTimeString();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Usuário criado e JWT encontrado',
            'tokenjwt' => $token,
            'expires' => $expires,
            'tokenmsg' => 'Use o token para acessar os endpoints!',
            'User' => $user
        ]);
    }
}
