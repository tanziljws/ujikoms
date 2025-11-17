<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🔹 Tampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

  // 🔹 Proses login
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // 🔒 Cek apakah akun nonaktif
        if (! $user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'loginError' => 'Akun Anda telah dinonaktifkan oleh admin.',
            ])->withInput();
        }

        $request->session()->regenerate(); // keamanan session fixation
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'loginError' => 'Email atau password salah!',
    ])->withInput();
}


    // 🔹 Tampilkan halaman register
    public function showRegister()
    {
        return view('register');
    }

    // 🔹 Proses register (hanya user)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // 🔒 default role user
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // 🔹 Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

   }


