<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::all();

        $dataUser = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'Nome' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'createdAt' => $user->created_at->format('Y-m-d H:i:s'),
                'updatedAt' => $user->updated_at->format('Y-m-d H:i:s'),
            ];
        });
        return response()->json(['Usuários' => $dataUser], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //valida os dados fornecidos
        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        //cria novo usuario no banco
        $user = User::create([
            'name' => $request->input('name'),
            'cpf' => $request->input('cpf'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['Message' => 'Usuário criado com sucesso', 'Usuário' => $user], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return response()->json(['Usuário'=>$user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'string',
            'cpf' => 'string',
            'email' => 'email',
            'password' => 'string|min:6',
        ]);

        $oldUser = $user->toArray();

        // Atualiza os dados do usuário
        $user->update([
            'name' => $request->input('name'),
            'cpf' => $request->input('cpf'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);


        return response()->json(['Message' => 'Usuário atualizado com sucesso',
         "Dados Antigo"  => $oldUser, 'Dados Atualizado' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //busca o usuário pelo id
        $user = User::findOrFail($id);

        //usuario que será deletado
        $userDeleted = $user->toArray();

        //exclui o usuario
        $user->delete();

        return response()->json([
            'Message' => 'Usuário excluído com sucesso',
            'Usuário' => $userDeleted,
        ], 200);

    }
}
