<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:10|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'role_id' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nrp' => $request->nrp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:10',
            'email' => 'required|string|email|max:255',
            'role_id' => 'required|integer',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('dashboard')->with('success', 'User updated successfully');
    }
}
