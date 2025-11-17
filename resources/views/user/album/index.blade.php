@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Judul -->
    <div class="text-center mb-10 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-gray-800">📸 Galeri Foto Sekolah</h2>
        <p class="text-gray-500 text-sm mt-2">Kumpulan momen terbaik di sekolah kami</p>
    </div>

    <!-- Kolom Pencarian -->
    <div class="flex justify-center mb-10 animate-fade-in-up">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Cari foto berdasarkan judul atau deskripsi..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-white/70 backdrop-blur-md border border-gray-200 shadow-md focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 text-gray-700 placeholder-gray-400"
            >
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
        </div>
    </div>

   

    {{-- Urutkan berdasarkan like terbanyak --}}
    @php
        $sortedPhotos = $photos->sortByDesc(function($photo) {
            $totalLikes = $photo->likes->count() + ($photo->guest_likes ?? 0);
            return $totalLikes;
        });
    @endphp

    {{-- Grid Foto --}}
    <div id="photoGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($sortedPhotos as $photo)
            <div class="photo-card group bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl opacity-0 scale-95"
                 data-title="{{ strtolower($photo->title) }}"
                 data-description="{{ strtolower($photo->description) }}">
                
                <!-- Foto + Overlay -->
                <div class="overflow-hidden relative">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" 
                         alt="{{ $photo->title }}" 
                         class="h-64 w-full object-cover transition duration-500 group-hover:scale-110">

                    <!-- Overlay hover -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <a href="{{ route('user.photo.show', $photo->id) }}" 
                           class="opacity-0 group-hover:opacity-100 transition duration-300 text-white text-lg font-semibold pointer-events-auto">
                            Lihat Detail 📷
                        </a>
                    </div>
                </div>

                <!-- Detail + Tombol -->
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $photo->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($photo->description, 60) }}</p>

                    <div class="flex items-center justify-between text-sm">
                        <!-- Tombol Like -->
                        <form action="{{ route('photo.like', $photo->id) }}" method="POST" class="flex items-center space-x-1">
                            @csrf
                            @php
                                $liked = auth()->check()
                                    ? $photo->likes->contains('user_id', auth()->id())
                                    : (in_array($photo->id, session('liked_photos', [])) ?? false);
                                $totalLikes = $photo->likes->count() + ($photo->guest_likes ?? 0);
                            @endphp
                            <button type="submit" class="flex items-center transition duration-300 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     viewBox="0 0 20 20" 
                                     fill="{{ $liked ? 'red' : 'none' }}" 
                                     stroke="currentColor"
                                     class="h-5 w-5 mr-1 {{ $liked ? 'text-red-500' : 'text-gray-400' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                </svg>
                                <span class="text-gray-700">{{ $totalLikes }}</span>
                            </button>
                        </form>

                        <!-- Tombol Comment -->
                        <a href="{{ route('user.album.show', $photo->id) }}" 
                           class="flex items-center text-gray-500 hover:text-blue-500 transition duration-300">
                            💬 <span class="ml-1">{{ $photo->comments->count() ?? 0 }}</span>
                        </a>

                        <!-- Tombol Download -->
                        <a href="{{ route('photo.download', [basename(dirname($photo->image)), basename($photo->image)]) }}"
                           class="flex items-center text-gray-500 hover:text-green-500 transition duration-300"
                           title="Download Foto">
                            ⬇️ <span class="ml-1">Download</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full animate-fade-in-up">
                <div class="bg-white shadow-md rounded-lg p-6 text-center text-gray-500">
                    Belum ada foto yang ditambahkan.
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

/* Scroll Reveal (fade + scale) */
.reveal-visible {
    opacity: 1 !important;
    transform: scale(1) translateY(0) !important;
    transition: all 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
}

/* Efek Hover */
.photo-card:hover img {
    filter: brightness(1.05);
}
</style>

{{-- Script Searching + Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const photoCards = document.querySelectorAll('.photo-card');

    // 🔍 Fitur Pencarian
    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();
        photoCards.forEach(card => {
            const title = card.getAttribute('data-title');
            const description = card.getAttribute('data-description');
            if (title.includes(query) || description.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // ✨ Scroll Reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('reveal-visible');
                }, index * 150);
            }
        });
    }, { threshold: 0.2 });

    photoCards.forEach(card => observer.observe(card));
});
</script>
@endsection
