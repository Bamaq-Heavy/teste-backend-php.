<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){

        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'O campo email está incorreto.',
                'email.email' => 'Insira um endereço de email válido.',
                'password.required' => 'O campo senha está incorreto.'
            ]);

            $credentials = $request->only('email', 'password');

            if(Auth::attempt($credentials)){

                //dataUser utilizado para apresentar dados na resposta de autenticação
                $user = Auth::user();
                $dataUser = [
                    'Name'=> $user->name,
                    'CPF' => $user->cpf,
                    'email' => $user->email,
                    'createdAt' => $user->created_at,
                    'updatedAt' => $user->updated_at,
                ];

                //codigo para liberar token twj
               $token = Auth('api')->attempt($credentials);

                return response()->json(['Status' => 'Success', 'Message' => 'Usuário Autorizado', 'Token JWT' => $token, 'user' => $dataUser], 200 );
            }
            else{
                return response()->json(['Status'=> 'Error','Message' => 'Email ou senha inválidos'], 500);
            }
        }catch(Exception $e){

            return response()->json(['Message' => $e->getMessage()], 401);
        }
    }
}
