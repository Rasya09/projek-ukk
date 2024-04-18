<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validasi inputan jika diperlukan
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        User::create($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Ambil semua foto yang dimiliki oleh pengguna ini
        $fotos = Foto::where('user_id', $id)->get();

        // Ambil daftar album milik pengguna
        $albums = $user->albums;

        // Tampilkan halaman detail profil dengan daftar foto pengguna
        return view('page.user.detail', compact('user', 'fotos'));
    }



    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validasi inputan jika diperlukan
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
