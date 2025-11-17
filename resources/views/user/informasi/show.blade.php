@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    <!-- Kartu utama -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden animate-fade-in">
        
        <!-- Gambar -->
        @if($informasi->foto)
            <div class="overflow-hidden bg-gray-100">
                <img src="{{ asset('storage/'.$informasi->foto) }}" 
                     alt="{{ $informasi->judul }}" 
                     class="w-full max-h-[600px] object-contain animate-image-fade">
            </div>
        @else
            <div class="h-72 flex items-center justify-center bg-gray-100 text-gray-400 text-lg animate-fade-in">
                📰 Tidak ada gambar
            </div>
        @endif

        <!-- Konten -->
        <div class="p-6 animate-content-up">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                {{ $informasi->judul }}
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                Dipublikasikan pada {{ $informasi->created_at->format('d M Y') }}
            </p>
            
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $informasi->isi_informasi }}
            </p>

            <div class="mt-6">
                <a href="{{ route('user.informasi.index') }}" 
                   class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                    ← Kembali ke daftar informasi
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Animasi lembut --}}
<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes imageFade {
    from { opacity: 0; transform: scale(1.03); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
    animation: fadeIn 0.8s ease-out both;
}
.animate-content-up {
    animation: fadeInUp 0.8s ease-out both;
}
.animate-image-fade {
    animation: imageFade 1.2s ease-out both;
}
</style>
@endsection
    