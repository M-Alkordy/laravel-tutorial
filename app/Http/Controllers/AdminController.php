<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.index', compact('users', 'roles', 'permissions'));
    }

    public function createRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create(['name' => $request->name]);

        return redirect()->route('admin.index')->with('success', 'Role created successfully.');
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|exists:roles,name']);
        // dd($user->roles);
        if ($user->roles->isNotEmpty()) {
            $user->removeRole($user->roles->first());
        }

        $user->assignRole($request->role);

        return redirect()->route('admin.index')->with('success', 'Role assigned successfully.');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            return redirect()->back()->with('error', 'The admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Role deleted successfully.');
    }

    public function assignPermissionToRole(Request $request, Role $role)
    {
        $request->validate(['permissions' => 'required|exists:permissions,name']);
        if ($role->name === 'admin') {
            return redirect()->back()->with('error', 'The admin permission can\'t be changed.');
        }
        $role->givePermissionTo($request->permissions);

        return redirect()->route('admin.index')->with('success', 'Permission assigned to role successfully.');
    }

    public function removePermissionFromRole(Request $request, Role $role)
    {
        $request->validate(['permissions' => 'required|exists:permissions,name']);
        if ($role->name === 'admin') {
            return redirect()->back()->with('error', 'The admin permission can\'t be changed');
        }
        $role->revokePermissionTo($request->permissions);

        return redirect()->route('admin.index')->with('success', 'Permission removed from role successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
