@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<style>
    /* ===== Animasi Fade In (Scroll Reveal) ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.8s forwards;
    }

    /* ===== Responsive Mobile ===== */
    @media (max-width: 640px) {

        #informasiGrid {
            grid-template-columns: 1fr !important;
            gap: 1.2rem !important;
        }

        .info-card {
            padding: 1.1rem !important;
            border-radius: 1rem !important;
        }

        .info-card img {
            width: 80px !important;
            height: 80px !important;
        }

        .info-card h3 {
            font-size: 1.1rem !important;
        }

        .info-card p {
            font-size: 14px !important;
        }
    }
</style>

<div class="container mx-auto px-4 py-10 reveal">

    <h2 class="text-3xl font-bold text-center text-blue-600 mb-6 reveal">📰 Kelola Informasi Sekolah</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-center font-medium shadow-sm reveal">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔍 Kolom Pencarian --}}
    <div class="flex justify-center mb-6 reveal">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchInformasi" 
                placeholder="Cari berdasarkan judul, deskripsi, atau isi informasi..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-white border border-gray-200 shadow-md 
                       focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 
                       text-gray-700 placeholder-gray-400"
            >

            <svg xmlns="https://www.w3.org/2000/svg" 
                 class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
        </div>
    </div>

    {{-- Tombol tambah --}}
    <div class="flex justify-end mb-4 reveal">
        <a href="{{ route('admin.informasi.create') }}" 
           class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md 
                  hover:bg-blue-700 hover:scale-[1.02] transition">
           + Tambah Informasi
        </a>
    </div>

    {{-- ============================
        📌 Versi Desktop (TABEL)
    ============================== --}}
    <div class="hidden md:block overflow-x-auto reveal">
        <table class="w-full bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-left">
                <tr>
                    <th class="p-3 text-center w-24">Foto</th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Isi Informasi</th>
                    <th class="p-3 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($informasis as $info)
                <tr class="border-b hover:bg-blue-50 transition reveal info-row"
                    data-judul="{{ strtolower($info->judul) }}"
                    data-deskripsi="{{ strtolower($info->deskripsi) }}"
                    data-isi="{{ strtolower($info->isi_informasi) }}"
                >
                    <td class="p-3 text-center align-middle">
                        @if($info->foto)
                            <img src="{{ asset('storage/'.$info->foto) }}" class="h-16 w-16 object-cover rounded-lg mx-auto shadow-sm">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>

                    <td class="p-3 font-semibold text-gray-800">{{ $info->judul }}</td>
                    <td class="p-3 text-gray-700">{{ Str::limit($info->deskripsi, 60) }}</td>
                    <td class="p-3 text-gray-600">{{ Str::limit($info->isi_informasi, 60) }}</td>

                    <td class="p-3 text-center space-x-2">
                        <a href="{{ route('admin.informasi.edit', $info->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition shadow-sm">Edit</a>

                        <form id="delete-{{ $info->id }}"
                              action="{{ route('admin.informasi.destroy', $info->id) }}" 
                              method="POST" 
                              class="inline-block"
                              onsubmit="confirmDelete(event ,'delete-{{ $info->id }}')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition shadow-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada informasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ============================
        📱 Versi Mobile (CARD)
    ============================== --}}
    <div id="informasiGrid" class="grid gap-5 mt-6 md:hidden">
        @forelse($informasis as $info)
            <div class="info-card bg-white rounded-xl shadow-md p-4 border border-gray-200 reveal"
                 data-judul="{{ strtolower($info->judul) }}"
                 data-deskripsi="{{ strtolower($info->deskripsi) }}"
                 data-isi="{{ strtolower($info->isi_informasi) }}">

                <div class="flex items-center space-x-4">
                    @if($info->foto)
                        <img src="{{ asset('storage/'.$info->foto) }}" class="h-20 w-20 object-cover rounded-lg shadow">
                    @else
                        <span class="text-gray-400 italic">Tidak ada</span>
                    @endif

                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-gray-800">{{ $info->judul }}</h3>
                    </div>
                </div>

                <p class="mt-3 text-gray-700 text-sm leading-relaxed"><b>Deskripsi:</b> {{ Str::limit($info->deskripsi, 120) }}</p>
                <p class="mt-2 text-gray-700 text-sm leading-relaxed"><b>Isi Informasi:</b> {{ Str::limit($info->isi_informasi, 120) }}</p>

                <div class="mt-4 flex justify-between">
                    <a href="{{ route('admin.informasi.edit', $info->id) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 transition">Edit</a>
                    
                    <form id="delete-{{ $info->id }}"
                        action="{{ route('admin.informasi.destroy', $info->id) }}" method="POST" onsubmit="confirmDelete(event ,'delete-{{ $info->id }}')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada informasi</p>
        @endforelse
    </div>

</div>

{{-- Searching + Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    const input = document.getElementById('searchInformasi');
    const rows = document.querySelectorAll('.info-row');
    const cards = document.querySelectorAll('.info-card');

    input.addEventListener('keyup', function() {
        const q = this.value.toLowerCase();

        rows.forEach(row => {
            const j = row.dataset.judul;
            const d = row.dataset.deskripsi;
            const i = row.dataset.isi;
            row.style.display = (j.includes(q) || d.includes(q) || i.includes(q)) ? '' : 'none';
        });

        cards.forEach(card => {
            const j = card.dataset.judul;
            const d = card.dataset.deskripsi;
            const i = card.dataset.isi;
            card.style.display = (j.includes(q) || d.includes(q) || i.includes(q)) ? '' : 'none';
        });
    });

    // Scroll Reveal
    const reveals = document.querySelectorAll('.reveal');
    const revealOnScroll = () => {
        reveals.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 80) {
                el.classList.add('active');
            }
        });
    };

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();
});
</script>

@endsection
