<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create','store']]);
        $this->middleware('permission:update role', ['only' => ['update','edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::with('permissions')->get(); // Load roles with permissions
        $permissions = Permission::all(); // Get all permissions
        return view('role.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions); // Sync permissions
        }
        return redirect()->route('roles.index')->with('success', 'Role added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $id]);
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions); // Sync permissions
        }
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
