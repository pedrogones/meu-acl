<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Traits\MessageTrait;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use MessageTrait;
    public function __construct()
    {
        $this->middleware('permission:user_view')->only(['index', 'show']);
        $this->middleware('permission:user_create')->only(['create', 'store']);
        $this->middleware('permission:user_update')->only(['edit', 'update']);
        $this->middleware('permission:user_delete')->only('destroy');
    }

    public function index()
    {
        $user = auth()->user();
        $users = User::query()->paginate(10);
        //dd($user);
        return view('user.index', compact('users', 'user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::query()->create($data);
            $user->roles()->attach($data['role_id']);
            return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
        } catch (Exception $e) {
            return back()->with('error', 'Não foi possível criar o usuário!');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
        } catch (Exception $e) {
            Log::info("Ocorreu um erro ao tentar remover o usuario: {$e}");
            return back()->with('error', 'Não foi possível remover o usuário!');
        }
    }

    public function edit(User $user)
    {
      $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }
    public function update(UserRequest $request, User $user)  {
        try {
            $data = $request->validated();
           $user->update($data);
           $user->roles()->sync($data['role_id']);
            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
        }  catch (Exception $e) {
            dd($e);
            Log::error("Ocorreu ao atualizar usuário: ".$e);
            return back()->with('error', 'Não foi possível atualizar o usuário!');
        }
    }

}
