<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Role $role)
    {
        $permissions = Permission::query()->get();
        return view('roles.permissions.index', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Role $role)
    {
       $permissions = collect($request->permissions);
       $permissionsId = $permissions->filter(fn($permission)=>$permission === 'on')->keys();
       try {
           $role->permissions()->sync($permissionsId);
           return redirect()->route('roles.index')->with('sucess', 'Permissões atualizadas com sucesso!');
    } catch (Exception $e) {
            Log::error("Aconteceu um erro ao tentar salvar uma nova permissão: ".$e);
            return redirect()->route('roles.permissions.index', $role)->with('error', "Ocorreu um erro!");
    }
    }


}
