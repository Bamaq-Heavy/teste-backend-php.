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
                $user = Auth::user();

                //cod para gerar token twj
                $token = $request->user()->createToken('token_simples');

                return response()->json(['Status' => 'Autorizado', 'Token' => $token, 'name'=> $user->name], 200 );
            }
        }catch(Exception $e){

            return response()->json(['Message' => $e->getMessage()], 401);
        }
    }
}
