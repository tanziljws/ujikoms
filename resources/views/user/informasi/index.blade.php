@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">

    <!-- Judul & Subjudul -->
    <div class="text-center mb-10 reveal">
        <h2 class="text-3xl font-bold text-gray-800">
            📘 Informasi Sekolah
        </h2>
        <p class="text-gray-500 text-sm mt-2">
            Kabar terbaru dan pengumuman penting dari sekolah
        </p>
        <div class="mt-3 w-16 h-1 bg-gray-300 mx-auto rounded-full"></div>
    </div>

    {{-- Grid Informasi --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($informasis as $info)
            <div class="group bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden transition duration-300 hover:shadow-lg opacity-0 scale-95 reveal"
                 data-judul="{{ strtolower($info->judul) }}">

                <!-- Gambar -->
                @if($info->foto)
                    <div class="overflow-hidden">
                        <img src="{{ asset('storage/'.$info->foto) }}" 
                             alt="{{ $info->judul }}" 
                             class="w-full h-56 object-cover transition duration-500 group-hover:scale-105">
                    </div>
                @else
                    <div class="h-56 flex items-center justify-center bg-gray-100 text-gray-400 text-lg">
                        📰 Tidak ada gambar
                    </div>
                @endif

                <!-- Isi Informasi -->
                <div class="p-6 text-center">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $info->judul }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        {{ Str::limit($info->deskripsi, 100) }}
                    </p>

                    <a href="{{ route('user.informasi.show', $info->id ?? '#') }}" 
class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                        Baca Selengkapnya →
                    </a>
                        <a href="{{ route('photo.download', ['informasi', basename($info->foto)]) }}"
    class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                        
   ⬇️ <span class="ml-1">Download</span>
</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center reveal">
                <div class="bg-white shadow rounded-lg p-6 text-gray-500">
                    Belum ada informasi sekolah.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Style & Animasi --}}
<style>
/* Animasi awal (fade-up untuk load pertama) */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-up {
    animation: fadeInUp 0.7s ease-out both;
}

/* Scroll Reveal (fade + scale) */
.reveal {
    opacity: 0;
    transform: translateY(30px) scale(0.97);
    transition: all 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
}
.reveal-visible {
    opacity: 1 !important;
    transform: translateY(0) scale(1) !important;
}
</style>

{{-- Script Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const revealElements = document.querySelectorAll('.reveal');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('reveal-visible');
                }, index * 150); // Delay biar muncul bergantian
            }
        });
    }, { threshold: 0.2 });

    revealElements.forEach(el => observer.observe(el));
});
</script>
@endsection
