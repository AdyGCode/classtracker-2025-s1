<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $users = User::with('roles')->get();

        return response()->json([
            'roles' => $roles,
            'users' => $users
        ]);
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findByName($request->role, 'web');

        if ($user->email_verified_at === null) {
            return response()->json(['message' => 'This user is not verified yet.'], 400);
        }

        if ($user->hasRole($role)) {
            return response()->json(['message' => 'This role is already assigned to the user.'], 409);
        }

        $user->syncRoles($role);
        return response()->json(['message' => 'Role assigned to user successfully.']);
    }

    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findByName($request->role, 'web');

        if (!$user->hasRole($role)) {
            return response()->json(['message' => 'This role is not assigned to the user.'], 409);
        }

        $user->removeRole($role);
        return response()->json(['message' => 'Role removed from user successfully.']);
    }

    public function getUserRoles(User $user)
    {
        return response()->json([
            'user' => $user->preferred_name,
            'roles' => $user->roles->pluck('name')
        ]);
    }
}
