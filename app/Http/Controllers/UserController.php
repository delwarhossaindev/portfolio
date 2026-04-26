<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'items' => User::with('roles')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.users.form', [
            'item' => new User(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:190|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->mixedCase()],
            'roles' => 'array|max:20',
            'roles.*' => 'string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('admin.users.index')->with('admin_success', 'User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'item' => $user,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'email' => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()->mixedCase()],
            'roles' => 'array|max:20',
            'roles.*' => 'string|exists:roles,name',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Prevent self-demotion: users editing themselves can't strip their own roles
        if (auth()->id() === $user->id && empty($data['roles'])) {
            // skip role sync to keep existing roles
        } else {
            $user->syncRoles($data['roles'] ?? []);
        }

        return redirect()->route('admin.users.index')->with('admin_success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('admin_success', 'User deleted.');
    }
}
