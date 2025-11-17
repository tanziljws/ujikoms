@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

    <div class="bg-white rounded-2xl shadow-md overflow-hidden animate-fade-in-up">
        @if($eskul->foto)
            <div class="w-full bg-gray-100 flex justify-center">
                <img src="{{ asset('storage/'.$eskul->foto) }}" 
                     alt="{{ $eskul->nama }}" 
                     class="max-h-[600px] w-auto object-contain rounded-t-2xl transition-transform duration-500 hover:scale-105">
            </div>
        @endif

        <div class="p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $eskul->nama }}</h2>
            <p class="text-blue-600 font-medium mb-4">Pembina: {{ $eskul->pembina ?? '-' }}</p>

            <p class="text-gray-700 leading-relaxed mb-6 whitespace-pre-line">{{ $eskul->deskripsi }}</p>

            <a href="{{ route('user.eskul.index') }}" 
               class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                ← Kembali ke Daftar Eskul
            </a>
        </div>
    </div>
</div>

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

/* Tambahan agar gambar menyesuaikan layar */
img {
    image-rendering: auto;
}
</style>
@endsection
