@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<style>
    /* ===== Fade In Animation ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-in-out both;
    }

    /* Scroll Reveal */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
    }

    .reveal-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="container mx-auto px-4 py-10 animate-fade-in-up">
    <h2 class="text-3xl font-bold text-center text-blue-600 mb-6 animate-fade-in-up">
        📋 Kelola Ekstrakurikuler
    </h2>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-center font-medium shadow-sm animate-fade-in-up">
            {{ session('success') }}
        </div>
    @endif

    <!-- 🔍 Kolom pencarian -->
    <div class="flex justify-center mb-6 animate-fade-in-up">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchEskul" 
                placeholder="Cari ekstrakurikuler berdasarkan nama atau pembina..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-white border border-gray-200 shadow-md focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 text-gray-700 placeholder-gray-400"
            >
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
        </div>
    </div>

    <!-- Tombol tambah -->
    <div class="flex justify-end mb-4 animate-fade-in-up">
        <a href="{{ route('admin.eskul.create') }}" 
           class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 hover:scale-[1.02] transition">
           + Tambah Eskul
        </a>
    </div>

    <!-- ✅ Versi desktop -->
    <div class="hidden md:block overflow-x-auto">
        <table id="eskulTable" class="w-full bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-left">
                <tr>
                    <th class="p-3 text-center w-24">Foto</th>
                    <th class="p-3">Nama Eskul</th>
                    <th class="p-3">Pembina</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eskuls as $eskul)
                <tr class="border-b hover:bg-blue-50 transition reveal eskul-row"
                    data-nama="{{ strtolower($eskul->nama) }}"
                    data-pembina="{{ strtolower($eskul->pembina ?? '') }}">
                    <td class="p-3 text-center align-middle">
                        @if($eskul->foto)
                            <img src="{{ asset('storage/'.$eskul->foto) }}" class="h-16 w-16 object-cover rounded-lg mx-auto shadow-sm">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="p-3 align-middle font-semibold text-gray-800">{{ $eskul->nama }}</td>
                    <td class="p-3 align-middle text-gray-700">{{ $eskul->pembina ?? '-' }}</td>
                    <td class="p-3 align-middle text-gray-600">{{ Str::limit($eskul->deskripsi, 60) }}</td>
                    <td class="p-3 text-center align-middle space-x-2">
                        <a href="{{ route('admin.eskul.edit', $eskul->id) }}" 
                           class="inline-block bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition shadow-sm">Edit</a>
                        <form id="delete--{{ $eskul->id }}"
                              action="{{ route('admin.eskul.destroy', $eskul->id) }}" 
                              method="POST" class="inline-block"
                              onsubmit="confirmDelete(event, 'delete--{{ $eskul->id }}')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition shadow-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data eskul</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ✅ Versi mobile -->
    <div id="eskulGrid" class="grid gap-5 mt-6 md:hidden">
        @forelse($eskuls as $eskul)
            <div class="eskul-card bg-white rounded-xl shadow-md p-4 border border-gray-200 reveal"
                 data-nama="{{ strtolower($eskul->nama) }}"
                 data-pembina="{{ strtolower($eskul->pembina ?? '') }}">
                <div class="flex items-center space-x-4">
                    @if($eskul->foto)
                        <img src="{{ asset('storage/'.$eskul->foto) }}" class="h-20 w-20 object-cover rounded-lg shadow">
                    @else
                        <span class="text-gray-400 italic">Tidak ada</span>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800">{{ $eskul->nama }}</h3>
                        <p class="text-sm text-gray-600">Pembina: {{ $eskul->pembina ?? '-' }}</p>
                    </div>
                </div>
                <p class="mt-3 text-gray-700 text-sm leading-relaxed">{{ Str::limit($eskul->deskripsi, 100) }}</p>
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('admin.eskul.edit', $eskul->id) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 transition">Edit</a>
                    <form id="delete--{{ $eskul->id }}"
                          action="{{ route('admin.eskul.destroy', $eskul->id) }}" 
                          method="POST" 
                          onsubmit="confirmDelete(event, 'delete--{{ $eskul->id }}')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada data eskul</p>
        @endforelse
    </div>
</div>

{{-- 🔍 Script Searching + Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchEskul');
    const rows = document.querySelectorAll('.eskul-row');
    const cards = document.querySelectorAll('.eskul-card');

    // 🔍 Searching
    input.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();

        [...rows, ...cards].forEach(el => {
            const nama = el.dataset.nama;
            const pembina = el.dataset.pembina;
            el.style.display = (nama.includes(query) || pembina.includes(query)) ? '' : 'none';
        });
    });

    // ✨ Scroll Reveal Animasi
    const revealElements = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('reveal-visible');
                }, index * 100);
            }
        });
    }, { threshold: 0.2 });

    revealElements.forEach(el => observer.observe(el));
});
</script>
@endsection
