<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth(guard: 'api')->attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Usuário não pode ser autenticado!'], 500);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $user = JWTAuth::setToken($token)->toUser();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuário criado e JWT encontrado',
            'tokenjwt' => $token,
            'expires' => JWTAuth::factory()->getTTL() * 60,
            'tokenmsg' => 'Use o token para acessar os endpoints!',
            'user' => $user
        ], Response::HTTP_OK);
    }
}
