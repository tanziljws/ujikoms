@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Judul & Subjudul -->
    <div class="text-center mb-10 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-gray-800">👩‍🏫 Daftar Guru</h2>
        <p class="text-gray-500 text-sm mt-2">Tenaga pengajar terbaik yang membimbing siswa dengan sepenuh hati</p>
    </div>

    <!-- Kolom Pencarian -->
    <div class="flex justify-center mb-10 animate-fade-in-up">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Cari nama guru atau mata pelajaran..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-gray-50 border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 text-gray-700 placeholder-gray-400"
            >
            <svg xmlns="https://www.w3.org/2000/svg" 
                 class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
        </div>
    </div>

    {{-- Grid Guru --}}
    <div id="guruGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($gurus as $guru)
            <div class="guru-card group bg-white rounded-2xl shadow-md overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-lg opacity-0 scale-95"
                 data-nama="{{ strtolower($guru->nama) }}"
                 data-mapel="{{ strtolower($guru->mapel ?? '') }}">
                
                <!-- Foto Guru -->
                <div class="overflow-hidden relative">
                    @if($guru->foto)
                        <img src="{{ asset('storage/'.$guru->foto) }}" 
                             alt="{{ $guru->nama }}" 
                             class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                    @else
                        <div class="h-64 flex items-center justify-center bg-gray-100 text-gray-400 text-lg">
                            👩‍🏫 Tidak ada foto
                        </div>
                    @endif
                </div>

                <!-- Detail Guru -->
                <div class="p-5 text-center">
                    <h3 class="text-xl font-bold text-gray-800">{{ $guru->nama }}</h3>
                    <p class="text-blue-600 font-medium">{{ $guru->mapel ?? '-' }}</p>
                    <p class="text-gray-600 mt-2">{{ Str::limit($guru->deskripsi, 60) }}</p>

                    <a href="{{ route('user.guru.show', $guru->id) }}" 
                       class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                        Lihat Detail
                    </a>
                     <a href="{{ route('photo.download', ['guru', basename($guru->foto)]) }}"
    class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                        
   ⬇️ <span class="ml-1">Download</span>
</a>
                </div>
            </div>
        @empty
            <div class="col-span-full animate-fade-in-up">
                <div class="bg-white shadow-md rounded-lg p-6 text-center text-gray-500">
                    Belum ada data guru.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Style & Animasi --}}
<style>
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

/* Efek Hover */
.guru-card:hover img {
    filter: brightness(1.05);
}

/* Scroll Reveal (fade + scale) */
.reveal-visible {
    opacity: 1 !important;
    transform: scale(1) translateY(0) !important;
    transition: all 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
}
</style>

{{-- Script Searching & Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const guruCards = document.querySelectorAll('.guru-card');

    // 🔍 Fitur Pencarian
    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();

        guruCards.forEach(card => {
            const nama = card.getAttribute('data-nama');
            const mapel = card.getAttribute('data-mapel');

            if (nama.includes(query) || mapel.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // ✨ Efek Scroll Reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('reveal-visible');
                }, index * 150); // delay bergantian
            }
        });
    }, { threshold: 0.2 });

    guruCards.forEach(card => observer.observe(card));
});
</script>
@endsection
