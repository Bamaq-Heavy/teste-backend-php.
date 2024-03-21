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
                return response()->json(['Status'=> 'Error','Message' => 'Usuário não pode ser autenticado'], 500);
            }
        }catch(Exception $e){

            return response()->json(['Message' => $e->getMessage()], 401);
        }
    }
}
