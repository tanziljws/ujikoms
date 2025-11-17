@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

    <div class="bg-white rounded-2xl shadow-md overflow-hidden animate-fade-in-up">
        @if($guru->foto)
            <div class="overflow-hidden bg-gray-100">
                <img src="{{ asset('storage/'.$guru->foto) }}" 
                     alt="{{ $guru->nama }}" 
                     class="w-full max-h-[600px] object-contain animate-image-fade">
            </div>
        @else
            <div class="h-72 flex items-center justify-center bg-gray-100 text-gray-400 text-lg animate-fade-in-up">
                📷 Tidak ada foto
            </div>
        @endif

        <div class="p-8 animate-content-up">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $guru->nama }}</h2>
            <p class="text-blue-600 font-medium mb-4">Mata Pelajaran: {{ $guru->mapel ?? '-' }}</p>

            <p class="text-gray-700 leading-relaxed mb-6 whitespace-pre-line">{{ $guru->deskripsi }}</p>

            <a href="{{ route('user.guru.index') }}" 
               class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">
                ← Kembali ke Daftar Guru
            </a>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes imageFade {
    from { opacity: 0; transform: scale(1.03); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-in-out both;
}
.animate-content-up {
    animation: fadeInUp 0.9s ease-in-out both;
}
.animate-image-fade {
    animation: imageFade 1.2s ease-out both;
}
</style>
@endsection
