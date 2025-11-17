@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6 mt-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-4">Edit User</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold">Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        
         <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded">
                    Kembali
                </a>
    </form>
</div>
@endsection
