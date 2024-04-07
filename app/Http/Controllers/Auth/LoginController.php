<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('page.login_page');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Otentikasi berhasil
            return redirect()->intended('/');
        }

        // Otentikasi gagal
        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'full_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
        ]);

        $user = new User([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'address' => $request->address,
        ]);

        $user->save();

        return redirect('/login')->with('success', 'Registration successful');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login')->with('success', 'Logout successful');
    }
}
