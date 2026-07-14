<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Rules\StrongPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', new StrongPassword()],
            'role'     => 'required|in:admin,trabajador',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        AuditLog::log('created', 'users', $user->id, null, $user->toArray());

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $old = $user->toArray();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,trabajador',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', new StrongPassword()]]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        AuditLog::log('updated', 'users', $user->id, $old, $user->toArray());

        return redirect()->route('users.index')->with('success', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $old = $user->toArray();
        $user->delete(); // soft delete

        AuditLog::log('deleted', 'users', $user->id, $old, null);

        return redirect()->route('users.index')->with('success', 'Usuario deshabilitado');
    }
}
