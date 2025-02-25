<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->paginate(5);

        return view('users.index', compact('data'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'family_name' => 'required',
            'given_name' => 'required',
            'preferred_name' => 'nullable',
            'pronouns' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $request['preferred_name'] = $request['preferred_name'] ?? $request['given_name'];

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        User::create($input);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user):RedirectResponse
    {
        $request->validate([
                'family_name' => 'required',
                'given_name' => 'required',
                'preferred_name' => 'nullable',
                'pronouns' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|same:password_confirmation|min:8',
            ]);

        $input = $request->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        $user->update($input);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
