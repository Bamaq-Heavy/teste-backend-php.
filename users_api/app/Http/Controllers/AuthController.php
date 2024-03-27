<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'Insira um endereço de email válido.',
                'password.required' => 'O campo senha é obrigatório.'
            ]);

            // Verifica se o usuário existe
            $user = User::where('email', $credentials['email'])->first();

            if ($user && Hash::check($credentials['password'], $user->password)) {
                // Autenticação bem-sucedida
                $dataUser = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ];

                $token = Auth::login($user); // Gerar token JWT

                return response()->json([
                    'status' => 'success',
                    'message' => 'Usuário autorizado',
                    'token' => $token,
                    'user' => $dataUser
                ], 200);
            } else {
                // Email ou senha inválidos
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email ou senha inválidos'
                ], 401);
            }
        } catch (\Exception $e) {
            // Erro genérico
            return response()->json([
                'message' => 'Erro ao processar a solicitação: ' . $e->getMessage()
            ], 500);
        }
    }
}
