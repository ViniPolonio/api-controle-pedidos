<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ResponseHelper;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return ResponseHelper::success($users, 'Usuários encontrados');
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return ResponseHelper::error('Usuário não encontrado', 404);
        }

        return ResponseHelper::success($user, 'Usuário encontrado');
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return ResponseHelper::success($user, 'Usuário criado com sucesso', 201);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return ResponseHelper::error('Usuário não encontrado', 404);
        }

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return ResponseHelper::success($user, 'Usuário atualizado com sucesso');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return ResponseHelper::error('Usuário não encontrado', 404);
        }

        $user->delete();

        return ResponseHelper::success(null, 'Usuário deletado com sucesso');
    }
}
