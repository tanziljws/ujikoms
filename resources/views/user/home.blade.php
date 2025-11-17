@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Hero Section --}}
    <section class="mb-12 bg-gradient-to-r from-blue-500 to-violet-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden animate-fade-in-up">
        <!-- Background overlay -->
        <div class="absolute inset-0 bg-[url('https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/861cfad0-2793-43bb-8359-48978dd49438.png')] opacity-5 pointer-events-none"></div>
        <div class="relative max-w-2xl">
            <h2 class="text-4xl font-bold mb-4">Galeri Kegiatan Sekolah</h2>
            <p class="text-lg mb-6">Temukan momen-momen berharga dari berbagai kegiatan siswa dan acara sekolah kami.</p>
            <a href="{{ route('user.album.index') }}"
               class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300 hover:shadow-lg inline-block">
                📷 Lihat Album Terbaru
            </a>
        </div>
    </section>

    {{-- Galeri --}}
    @php
        use App\Models\Photo;
        $photos = Photo::with(['likes', 'comments'])
            ->withCount('likes')
            ->orderByDesc(\DB::raw('likes_count + COALESCE(guest_likes, 0)'))
            ->take(8)
            ->get();
    @endphp

    <div class="text-center mb-10 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-gray-800">📸 Galeri Terpopuler</h2>
        <p class="text-gray-500 text-sm mt-2">Momen terbaik pilihan siswa & tamu</p>
    </div>

    <div id="photoGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($photos as $photo)
            <div class="photo-card group bg-white rounded-2xl shadow-md overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-lg opacity-0 scale-95">

                <!-- Klik ke halaman show -->
                <a href="{{ route('user.photo.show', $photo->id) }}" class="block relative">
                    <img src="{{ asset('storage/'.$photo->image) }}" 
                         alt="{{ $photo->title }}" 
                         class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition pointer-events-none"></div>
                </a>

                <!-- Body Card -->
                <div class="p-4 text-center">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $photo->title }}</h5>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $photo->description }}</p>

                    <!-- Like, Comment & Download -->
                    <div class="flex items-center justify-between mt-3 px-4">
                        {{-- Tombol Like --}}
                        <form action="{{ route('photo.like', $photo->id) }}" method="POST">
                            @csrf
                            @php
                                $liked = auth()->check() 
                                    ? $photo->likes->contains('user_id', auth()->id())
                                    : (session()->has('liked_photos') && in_array($photo->id, session('liked_photos')));
                            @endphp
                            <button type="submit" 
                                class="flex items-center space-x-1 text-gray-600 hover:text-red-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     fill="{{ $liked ? 'red' : 'none' }}" 
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                                     class="w-5 h-5 {{ $liked ? 'text-red-500' : 'text-gray-500' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M21 8.25c0-2.485-2.239-4.5-5-4.5-1.657 0-3.13.842-4 
                                          2.118A4.992 4.992 0 008 3.75c-2.761 0-5 
                                          2.015-5 4.5 0 7.25 9 11.25 9 
                                          11.25s9-4 9-11.25z" />
                                </svg>
                                <span class="text-sm">
                                    {{ $photo->likes->count() + ($photo->guest_likes ?? 0) }}
                                </span>
                            </button>
                        </form>

                        {{-- Tombol Comment --}}
                        <a href="{{ route('user.photo.show', $photo->id) }}" 
                           class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 transition">
                            💬 <span class="text-sm">{{ $photo->comments->count() }}</span>
                        </a>

                        {{-- Tombol Download --}}
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
                    Belum ada foto di galeri.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Tombol Lihat Semua --}}
    <div class="text-center mt-10 animate-fade-in-up">
        <a href="{{ route('user.album.index') }}" 
           class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            📖 Lihat Semua Foto
        </a>
    </div>

    {{-- Event --}}
    <div class="mt-16 animate-fade-in-up">
        @include('components.events')
    </div>
</div>

{{-- Style & Animasi --}}
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up { animation: fadeInUp 0.8s ease-in-out both; }

.photo-card:hover img { filter: brightness(1.05); }

.reveal-visible { 
    opacity: 1 !important; 
    transform: scale(1) translateY(0) !important; 
    transition: all 0.8s cubic-bezier(0.2,0.6,0.3,1); 
}
</style>

{{-- Script Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoCards = document.querySelectorAll('.photo-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if(entry.isIntersecting){
                setTimeout(()=>{ entry.target.classList.add('reveal-visible'); }, index*150);
            }
        });
    }, { threshold: 0.2 });

    photoCards.forEach(card => observer.observe(card));
});
</script>
@endsection
