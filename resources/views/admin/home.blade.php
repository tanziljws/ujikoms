@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="mb-10 animate-fade-in-up text-center md:text-left">
        <h2 class="text-3xl font-bold text-gray-800">👋 Selamat Datang, Admin!</h2>
        <p class="text-gray-500 text-sm mt-2">Berikut ringkasan informasi pengguna dan aktivitas terbaru.</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in-up">
        <div class="bg-gradient-to-r from-blue-500 to-sky-400 text-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-2">Total Pengguna</h3>
            <p class="text-4xl font-bold">{{ \App\Models\User::count() }}</p>
        </div>

        <div class="bg-gradient-to-r from-violet-500 to-purple-500 text-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-2">Album Terunggah</h3>
            <p class="text-4xl font-bold">{{ \App\Models\Photo::count() }}</p>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-2">Komentar Masuk</h3>
            <p class="text-4xl font-bold">{{ \App\Models\Comment::count() }}</p>
        </div>

        {{-- Foto Populer: semua foto yang punya like >= 5 --}}
        <div class="bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-2">Foto Terpopuler</h3>
          <p class="text-4xl font-bold">
{{ 
    \App\Models\Photo::withCount('likes')
        ->get()
        ->filter(fn($p) => ($p->likes_count + $p->guest_likes) >= 5)
        ->count()
}}







</p>



        </div>
    </div>

    {{-- Daftar Pengguna Terbaru --}}
    <div class="bg-white rounded-2xl shadow-md p-6 mb-12 animate-fade-in-up">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">🧑‍💼 Pengguna Terbaru</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm uppercase">
                        <th class="p-3 rounded-tl-xl">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Tanggal Daftar</th>
                        <th class="p-3 rounded-tr-xl">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3 font-medium text-gray-800 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="p-3 text-gray-600 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="p-3 text-gray-500 whitespace-nowrap">{{ optional($user->created_at)->format('d M Y') ?? '-' }}
</td>
                        <td class="p-3 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs rounded-full 
                                {{ $user->is_admin ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="text-xs text-gray-500 mt-3 sm:hidden text-center">
            Geser tabel ke kanan untuk melihat seluruh data →
        </p>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in-up">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">🕒 Aktivitas Terbaru</h3>
        <ul class="space-y-3">
            @foreach(\App\Models\Photo::latest()->take(5)->get() as $photo)
                <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b pb-2">
                    <div class="mb-2 sm:mb-0">
                        <p class="text-gray-800 font-medium">{{ $photo->title }}</p>
                        <p class="text-sm text-gray-500">
                            Diunggah oleh {{ $photo->user->name ?? 'Tamu' }} pada {{ optional($photo->created_at)->format('d M Y') ?? '-' }}

                        </p>
                    </div>
                    <a href="{{ route('user.photo.show', $photo->id) }}" 
                       class="text-blue-600 hover:underline text-sm">Lihat</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- Animasi --}}
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.7s ease-in-out both;
}
.overflow-x-auto {
    -webkit-overflow-scrolling: touch;
}
</style>
@endsection
