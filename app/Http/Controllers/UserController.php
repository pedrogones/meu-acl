<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user=User::query()->paginate(10);
        return view('user.index', ['users'=>$user]);
    }
    public function create(){
        return view('user.create');
    }
    public function store(UserRequest $request){
        $data = $request->validated();
        User::query()->create(($data));
        return back();
    }
    public function destroy(User $user){
       $user->delete();
       return back();
    }
    public function edit(User $user){
        return view('user.edit', ['user'=>$user]);
    }
    public function update(UserRequest $request, User $user){

        $data = $request->validated();
        $user->update($data);
        return redirect()->route('users.index');
    }

}