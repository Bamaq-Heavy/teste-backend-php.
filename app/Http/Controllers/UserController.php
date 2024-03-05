<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $hash;

    public function __construct(Hash $hash)
    {
        $this->hash = $hash;
    }

    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar usuários'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Usuário excluído com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir o usuário'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $this->hash::make($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário registrado com sucesso',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar o usuário'], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Nenhum usuário encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o usuário'], 500);
        }
    }
}