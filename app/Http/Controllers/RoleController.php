<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function list() {
        $roles = Role::get();
        return view('Admin.Role.list', compact('roles'));
    }

    public function edit($id)
    {
        $role = Role::whereid($id)->with('permissions')->first();
        $permissions = Permission::all();
        return view('Admin.Role.edit', compact('role', 'permissions'));
    }
}
