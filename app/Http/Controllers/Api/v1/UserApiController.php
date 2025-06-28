<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /**
     * A Paginated List of (all) Users
     *
     * <ul>
     * <li>The users are searchable.</li>
     * <li>Filter users by SEARCH_TERM: <code>?search=SEARCH_TERM</code></li>
     * <li>The users are paginated.</li>
     * <li>Jump to page PAGE_NUMBER: <code>page=PAGE_NUMBER</code></li>
     * <li>Provide USERS_PER_PAGE per page: <code>perPage=USERS_PER_PAGE</code></li>
     * <li>Example URI: <code>http://localhost:8000/api/v1/users?search=John&page=1&perPage=5</code></li>
     * </ul>
     *
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'page' => ['nullable', 'integer'],
            'perPage' => ['nullable', 'integer'],
            'search' => ['nullable', 'string'],
        ]);

        $perPage = $request->perPage ?? 6;
        $search = $request->search;

        $query = User::query();

        $searchableFields = ['given_name', 'family_name', 'preferred_name', 'pronouns', 'email'];

        if ($search) {
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', '%' . $search . '%');
                }
            });
        }

        $users = $query->paginate($perPage);

        if ($users->isNotEmpty()) {
            return ApiResponse::success($users, 'All Users Found');
        }

        return ApiResponse::error([], 'No Users Found', 404);
    }

    /**
     * Store a newly created User resource.
     *
     * <ul>
     * <li>Default role assigned: <code>Student</code></li>
     * <li>Password will be hashed automatically.</li>
     * <li><code>preferred_name</code> will fallback to <code>given_name</code> if not provided.</li>
     * </ul>
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'family_name' => 'required',
            'given_name' => 'required',
            'preferred_name' => 'nullable',
            'pronouns' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $input = $request->all();

        $input['preferred_name'] = $input['preferred_name'] ?? $input['given_name'];
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole('Student');

        return ApiResponse::success($user, 'User created successfully', 201);
    }

    /**
     * Display the specified User by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::find($id);

        if ($user) {
            return ApiResponse::success($user, 'Specific User Found');
        }

        return ApiResponse::error([], 'Specific User Not Found', 404);
    }

    /**
     * Update the specified User resource.
     *
     * <ul>
     * <li>Only updates password if provided.</li>
     * <li>Email remains unique across users.</li>
     * <li>Password is rehashed if changed.</li>
     * </ul>
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'family_name' => 'required',
            'given_name' => 'required',
            'preferred_name' => 'nullable',
            'pronouns' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        $input = $request->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        $user->update($input);

        return ApiResponse::success($user, 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error([], 'Specific User Not Found', 404);
        }

        $user->delete();
        return ApiResponse::success([], 'User deleted successfully');
    }
}
