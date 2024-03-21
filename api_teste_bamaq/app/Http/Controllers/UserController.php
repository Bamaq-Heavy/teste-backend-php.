<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;


class UserController extends Controller
{
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
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
        } catch (Exception) {
            return response()->json(['Message' => 'Usuário já cadastrado no banco de dados']);
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['Usuário' => $user], 200);
        } catch (\Exception) {

            return response()->json(['Status' => 'Error', 'Message' => 'ID não corresponde a nenhum usuário'], 404);
        }
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            //verifica se os dados novos já pertencem a outro usuário cadastrado no banco de dados
            $existUser = User::where('email', $request->input('email'))
            ->where('id', '<>', $id)
            ->first();

            if($existUser){
                return response()->json(['Message' => 'Os dados atualizados já pertencem a outro usuário do banco de dados'], 409);

            }

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


            return response()->json([
                'Message' => 'Usuário atualizado com sucesso',
                "Dados Antigo"  => $oldUser, 'Dados Atualizado' => $user
            ], 200);
        } catch (Exception) {
            return response()->json(['Message' => 'ID não corresponde a nenhum usuário no banco de dados']);
        }
    }

    public function destroy(string $id)
    {
        try {
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
        } catch (Exception) {
            return response()->json(['Message' => 'ID não corresponde a nenhum usuário']);
        }
    }
}
