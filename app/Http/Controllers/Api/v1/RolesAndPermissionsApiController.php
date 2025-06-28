<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsApiController extends Controller
{
    /**
     * Get all Roles and Users with Roles
     *
     * <ul>
     * <li>Returns all available roles.</li>
     * <li>Returns all users and their assigned roles.</li>
     * </ul>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = Role::all();
        $users = User::with('roles')->get();

        if ($roles->isEmpty() && $users->isEmpty()) {
            return ApiResponse::error(null, 'No roles or users found', 404);
        }

        return ApiResponse::success([
            'roles' => $roles,
            'users' => $users
        ], 'Roles and users retrieved successfully');
    }

    /**
     * Assign a Role to a User
     *
     * <ul>
     * <li>Only assigns a role if user exists and is verified.</li>
     * <li>Fails if role is already assigned.</li>
     * <li>Available roles must already exist in database.</li>
     * </ul>
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($request->user_id);
        $role = Role::findByName($request->role, 'web');

        if (!$user) {
            return ApiResponse::error(null, 'User not found', 404);
        }

        if ($user->email_verified_at === null) {
            return ApiResponse::error(null, 'This user is not verified yet.', 400);
        }

        if ($user->hasRole($role)) {
            return ApiResponse::error(null, 'This role is already assigned to the user.', 409);
        }

        $user->syncRoles($role);
        return ApiResponse::success(null, 'Role assigned to user successfully.');
    }

    /**
     * Remove a Role from a User
     *
     * <ul>
     * <li>Only removes a role if the user and role exist.</li>
     * <li>Fails if the role is not currently assigned.</li>
     * </ul>
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($request->user_id);
        $role = Role::findByName($request->role, 'web');

        if (!$user) {
            return ApiResponse::error(null, 'User not found', 404);
        }

        if (!$user->hasRole($role)) {
            return ApiResponse::error(null, 'This role is not assigned to the user.', 409);
        }

        $user->removeRole($role);
        return ApiResponse::success(null, 'Role removed from user successfully.');
    }

    /**
     * Get All Roles Assigned to a Specific User
     *
     * <ul>
     * <li>Returns the user's preferred name.</li>
     * <li>Returns an array of all roles currently assigned.</li>
     * </ul>
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRoles(User $user)
    {
        return ApiResponse::success([
            'user' => $user->preferred_name,
            'roles' => $user->roles->pluck('name')
        ], 'User roles retrieved successfully');
    }
}
