@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<style>
    /* ===== Animasi Fade In ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        opacity: 0;
        animation: fadeInUp 0.8s forwards;
    }

    /* Delay tiap elemen biar muncul bertahap */
    @foreach(range(1, 50) as $i)
        .fade-in-{{ $i }} { animation-delay: {{ $i * 0.1 }}s; }
    @endforeach
</style>

<div class="container mx-auto px-4 py-10 fade-in fade-in-1">
    <!-- Judul Halaman -->
    <h2 class="text-3xl font-bold text-center text-blue-600 mb-6 fade-in fade-in-2">
        👨‍🏫 Kelola Data Guru
    </h2>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-center font-medium shadow-sm fade-in fade-in-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- 🔍 Kolom Pencarian -->
    <div class="flex justify-center mb-6 fade-in fade-in-4">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchGuru" 
                placeholder="Cari guru berdasarkan nama atau mapel..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-white border border-gray-200 shadow-md 
                       focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 
                       text-gray-700 placeholder-gray-400"
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
    <div class="flex justify-end mb-4 fade-in fade-in-5">
        <a href="{{ route('admin.guru.create') }}" 
           class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md 
                  hover:bg-blue-700 hover:scale-[1.02] transition">
           + Tambah Guru
        </a>
    </div>

    <!-- ✅ Versi Desktop -->
    <div class="hidden md:block overflow-x-auto fade-in fade-in-6">
        <table id="guruTable" class="w-full bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-left">
                <tr>
                    <th class="p-3 text-center w-24">Foto</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Mapel</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $index => $guru)
                <tr class="border-b hover:bg-blue-50 transition fade-in fade-in-{{ $index + 7 }} guru-row"
                    data-nama="{{ strtolower($guru->nama) }}"
                    data-mapel="{{ strtolower($guru->mapel ?? '') }}">
                    <td class="p-3 text-center align-middle">
                        @if($guru->foto)
                            <img src="{{ asset('storage/'.$guru->foto) }}" class="h-16 w-16 object-cover rounded-full mx-auto shadow-sm">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="p-3 font-semibold text-gray-800">{{ $guru->nama }}</td>
                    <td class="p-3 text-gray-700">{{ $guru->mapel }}</td>
                    <td class="p-3 text-gray-600">{{ Str::limit($guru->deskripsi, 60) }}</td>
                    <td class="p-3 text-center space-x-2">
                        <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition shadow-sm">Edit</a>
                        <form  id="delete--{{ $guru->id }}"
                              action="{{ route('admin.guru.destroy', $guru->id) }}" 
                              method="POST" class="inline-block"
                              onsubmit="confirmDelete(event, 'delete--{{ $guru->id }}')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition shadow-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 fade-in fade-in-50">Belum ada data guru</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ✅ Versi Mobile -->
    <div id="guruGrid" class="grid gap-5 mt-6 md:hidden">
        @forelse($gurus as $index => $guru)
            <div class="guru-card bg-white rounded-xl shadow-md p-4 border border-gray-200 fade-in fade-in-{{ $index + 7 }}"
                 data-nama="{{ strtolower($guru->nama) }}"
                 data-mapel="{{ strtolower($guru->mapel ?? '') }}">
                <div class="flex items-center space-x-4">
                    @if($guru->foto)
                        <img src="{{ asset('storage/'.$guru->foto) }}" class="h-20 w-20 object-cover rounded-full shadow">
                    @else
                        <span class="text-gray-400 italic">Tidak ada</span>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800">{{ $guru->nama }}</h3>
                        <p class="text-sm text-gray-600">Mapel: {{ $guru->mapel }}</p>
                    </div>
                </div>
                <p class="mt-3 text-gray-700 text-sm leading-relaxed">{{ Str::limit($guru->deskripsi, 100) }}</p>
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 transition">Edit</a>

                       
                       <form  id="delete--{{ $guru->i }}"
                              action="{{ route('admin.guru.destroy', $guru->id) }}" 
                              method="POST" 
                              onsubmit="confirmDelete(event, 'delete--{{ $guru->id }}')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 fade-in fade-in-50">Belum ada data guru</p>
        @endforelse
    </div>
</div>

{{-- 🔍 Script Searching --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchGuru');
    const rows = document.querySelectorAll('.guru-row');
    const cards = document.querySelectorAll('.guru-card');

    input.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.dataset.nama;
            const mapel = row.dataset.mapel;
            row.style.display = (nama.includes(query) || mapel.includes(query)) ? '' : 'none';
        });

        cards.forEach(card => {
            const nama = card.dataset.nama;
            const mapel = card.dataset.mapel;
            card.style.display = (nama.includes(query) || mapel.includes(query)) ? '' : 'none';
        });
    });
});
</script>

{{-- 🚀 Scroll Reveal --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("fade-in");
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll(".fade-in").forEach(el => observer.observe(el));
});
</script>
@endsection
