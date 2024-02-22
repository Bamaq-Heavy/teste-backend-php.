<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update($request->all());

        return response()->json($user, Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, Response::HTTP_OK);
    }
}
