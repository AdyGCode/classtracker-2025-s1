<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::all();
        return view('roles-permissions.index', compact('roles', 'users'));
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user);
        $role = Role::findByName($request->role, 'web');

        if ($user->email_verified_at === null) {
            return redirect()->back()->with('warning', 'This user is not verified yet.');
        }

        if (auth()->user()->hasRole('Administrator') && $role->name === 'Super Admin') {
            return redirect()->back()->with('warning', 'Administrator cannot assign users to Super Admin.');
        }

        if (auth()->user()->hasRole('Super Admin') && $role->name === 'Super Admin') {
            return redirect()->back()->with('warning', 'Super Admin cannot assign users to Super Admin.');
        }

        if ($user->hasRole($role)) {
            return redirect()->back()->with('warning', 'This role is already assigned to the user.');
        }

        $user->syncRoles($role);
        return redirect()->back()->with('success', 'Role assigned to user successfully.');
    }

    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findByName($request->role, 'web');

        if (auth()->user()->hasRole('Super Admin') && $role->name === 'Super Admin') {
            return redirect()->back()->with('warning', 'Super Admin cannot remove the Super Admin role.');
        }

        if (auth()->user()->hasRole('Administrator') && in_array($role->name, ['Administrator', 'Super Admin'])) {
            return redirect()->back()->with('warning', 'Administrators cannot remove Administrator or Super Admin roles.');
        }

        if (!$user->hasRole($role)) {
            return redirect()->back()->with('warning', 'This role is not assigned to the user.');
        }

        $user->removeRole($role);
        return redirect()->back()->with('success', 'Role removed from user successfully.');
    }
}
