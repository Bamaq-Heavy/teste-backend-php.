<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

//desacoplamento do controller
class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser(array $dadosUser)
    {
        $dadosUser['password'] = Hash::make($dadosUser['password']);
        return User::create($dadosUser);
    }

    public function updateUser(array $dadosUser, $userId)
    {
        $user = User::findOrFail($userId);
        $user->update($dadosUser);
        return $user;
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
    }
}
