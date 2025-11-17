@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Judul & Tombol -->
    <div class="flex items-center justify-between mb-8 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-gray-800">📸 Album Foto Sekolah</h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.album.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-200 hover:scale-105">
                ➕ Tambah Foto
            </a>
            <a href="{{ route('user.album.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-200 hover:scale-105">
                👥 Lihat Album User
            </a>
        </div>
    </div>

    <!-- Kolom Pencarian -->
    <div class="flex justify-center mb-10 animate-fade-in-up">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Cari foto berdasarkan judul atau deskripsi..." 
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

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 shadow-sm animate-fade-in-up">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid Foto -->
    <div id="photoGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($photos as $photo)
            <div class="photo-card group bg-white rounded-2xl shadow-lg overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-xl opacity-0 scale-95"
                 data-title="{{ strtolower($photo->title) }}"
                 data-description="{{ strtolower($photo->description ?? '') }}">

                <!-- Gambar -->
                <div class="overflow-hidden relative">
                    @if($photo->image && file_exists(storage_path('app/public/'.$photo->image)))
                        <img src="{{ asset('storage/'.$photo->image) }}" 
                             alt="{{ $photo->title }}" 
                             class="h-56 w-full object-cover transition duration-500 group-hover:scale-110">
                    @else
                        <div class="h-56 flex items-center justify-center bg-gray-100 text-gray-400 text-lg">
                            📷 Tidak ada gambar
                        </div>
                    @endif
                </div>

                <!-- Detail -->
                <div class="p-4 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $photo->title }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($photo->description, 60) }}</p>

                    <div class="mt-4 flex justify-center space-x-2">
                        <!-- Edit -->
                        <a href="{{ route('admin.album.edit', $photo->id) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md shadow-sm text-sm transition duration-200 hover:scale-105">
                            ✏️ Edit
                        </a>

                        <!-- Hapus -->
                       <form id="delete-photo-{{ $photo->id }}" 
      action="{{ route('admin.album.destroy', $photo->id) }}" 
      method="POST" 
      class="inline-block">
    @csrf
    @method('DELETE')

    <button type="button"
            onclick="confirmDelete(event, 'delete-photo-{{ $photo->id }}')"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md shadow-sm text-sm transition duration-200 hover:scale-105">
        🗑 Hapus
    </button>
</form>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full animate-fade-in-up">
                <div class="bg-white shadow-md rounded-lg p-6 text-center text-gray-500">
                    Belum ada foto di album.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- ✨ Style & Animasi --}}
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

/* Scroll reveal smooth */
.reveal-visible {
    opacity: 1 !important;
    transform: scale(1) translateY(0) !important;
    transition: all 0.8s cubic-bezier(0.2, 0.6, 0.3, 1);
}
</style>

{{-- 🔍 Search + Scroll Reveal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const photoCards = document.querySelectorAll('.photo-card');

    // 🔍 Fitur pencarian
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

    // ✨ Efek Scroll Reveal
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
