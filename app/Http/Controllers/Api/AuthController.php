<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Email atau password salah.'
        ], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    if ($user->role === 'admin') {
        return response()->json([
            'message' => 'Login berhasil sebagai admin',
            'role'    => 'admin',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    return response()->json([
        'message' => 'Login berhasil sebagai user',
        'role'    => 'user',
        'token'   => $token,
        'user'    => $user
    ]);
}


}
