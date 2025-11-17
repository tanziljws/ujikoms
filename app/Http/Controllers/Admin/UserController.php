<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 🧍‍♂️ Daftar user
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // ✏️ Edit user
    public function edit(User $user)
    {
        // 🚫 Cegah edit akun sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Anda tidak dapat mengedit akun Anda sendiri!');
        }

        // 🚫 Cegah edit super admin
        if ($user->email === 'admin@example.com') {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Akun admin utama tidak dapat diubah!');
        }

        return view('admin.users.edit', compact('user'));
    }

    // 💾 Update user
    public function update(Request $request, User $user)
    {
        // 🚫 Cegah update akun sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Anda tidak dapat mengubah data akun Anda sendiri!');
        }

        // 🚫 Cegah update super admin
        if ($user->email === 'admin@example.com') {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Akun admin utama tidak dapat diubah!');
        }

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required',
        ]);

        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('users.index')->with('success', '✅ User berhasil diperbarui.');
    }

    // 🗑️ Hapus user
    public function destroy(User $user)
    {
        // 🚫 Cegah hapus akun sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // 🚫 Cegah hapus super admin
        if ($user->email === 'admin@example.com') {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Akun admin utama tidak dapat dihapus!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', '🗑️ User berhasil dihapus.');
    }

    // 🔄 Ubah status aktif/nonaktif
    public function toggleStatus(User $user)
    {
        // 🚫 Cegah nonaktifkan akun sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        // 🚫 Cegah nonaktifkan super admin
        if ($user->email === 'admin@example.com') {
            return redirect()->route('users.index')
                ->with('warning', '⚠️ Akun admin utama tidak dapat dinonaktifkan!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('users.index')->with('success', '✅ Status user berhasil diubah.');
    }
}
