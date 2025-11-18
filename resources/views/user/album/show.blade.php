@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10 animate-fade-in-up">

    <!-- Tombol Kembali -->
    <div class="mb-6">
        @auth
            <a href="{{ route('user.album.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 transition text-sm font-medium">
                ⬅️ Kembali ke Galeri
            </a>
        @endauth

        @guest
            <a href="{{ url('/') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 transition text-sm font-medium">
                ⬅️ Kembali ke Beranda
            </a>
        @endguest
    </div>

    <!-- Kartu Foto -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition duration-300 hover:shadow-2xl">

        <div class="flex flex-col md:flex-row">
            <!-- Foto -->
            <div class="md:w-1/2 relative overflow-hidden">
                <img src="{{ asset('storage/' . $photo->image_path) }}" 
                     alt="{{ $photo->title }}" 
                     class="w-full max-h-[400px] md:max-h-[100%] object-cover transition duration-700 ease-in-out hover:scale-105">
            </div>

            <!-- Detail Foto -->
            <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $photo->title }}</h2>
                    <p class="text-gray-600 leading-relaxed mb-5">{{ $photo->description }}</p>
                </div>

                <!-- Like & Komentar Count -->
                <div class="flex items-center justify-between mb-6">
                    {{-- Tombol Like --}}
                    <form action="{{ route('photo.like', $photo->id) }}" method="POST">
                        @csrf
                        @php
                            $liked = Auth::check() 
                                ? $photo->likes->contains('user_id', auth()->id())
                                : (session()->has('liked_photos') && in_array($photo->id, session('liked_photos')));
                        @endphp

                        <button type="submit" 
                            class="flex items-center space-x-2 px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 transition">
                            <svg xmlns="https://www.w3.org/2000/svg" 
                                 viewBox="0 0 20 20" fill="currentColor"
                                 class="h-5 w-5 {{ $liked ? 'text-red-500' : 'text-gray-400' }}">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 
                                115.656 5.656L10 17.657l-6.828-6.829a4 4 0 
                                010-5.656z" />
                            </svg>
                            <span class="text-sm text-gray-700">{{ $photo->likes->count() + ($photo->guest_likes ?? 0) }}</span>
                        </button>
                    </form>

                    <div class="text-gray-500 text-sm">
                        💬 {{ $photo->comments->count() }} komentar
                    </div>
                </div>
            </div>
        </div>

        <!-- Komentar Section -->
        <div class="border-t p-6 md:p-8 bg-gray-50">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">💬 Komentar</h3>

            <!-- List Komentar -->
            <div class="space-y-4 max-h-72 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @forelse ($photo->comments as $comment)
                    @php
                        $isAdmin = $comment->user->role === 'admin';
                        $canDelete = Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->role === 'admin');
                    @endphp

                    <div class="flex items-start space-x-3 p-3 rounded-xl bg-white border border-gray-100 hover:bg-gray-100 transition">
                        {{-- Avatar --}}
                        <div class="w-10 h-10 flex items-center justify-center rounded-full 
                            {{ $isAdmin ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>

                        {{-- Isi komentar --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                    @if($isAdmin)
                                        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                            Admin
                                        </span>
                                    @endif
                                </div>

                                {{-- Tombol Hapus --}}
                                @if($canDelete)
                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-xs hover:text-red-700">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <p class="text-gray-700 text-sm mt-1 leading-relaxed">{{ $comment->content }}</p>
                            <span class="text-xs text-gray-400 block mt-1">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada komentar.</p>
                @endforelse
            </div>

            {{-- Form komentar --}}
            @auth
                <form action="{{ route('photo.comment', $photo->id) }}" method="POST" class="mt-6">
                    @csrf
                    <textarea name="content" rows="3" placeholder="Tulis komentar kamu..." 
                        class="border w-full p-3 rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none"></textarea>
                    <button type="submit" 
                        class="mt-3 w-full bg-blue-600 text-white text-sm py-2.5 rounded-lg hover:bg-blue-700 transition">
                        Kirim Komentar
                    </button>
                </form>
            @else
                <div class="mt-6">
                    <textarea disabled rows="3" placeholder="Login dulu untuk menulis komentar..." 
                        class="border w-full p-3 rounded-lg text-sm bg-gray-100 text-gray-500 cursor-not-allowed"></textarea>
                    <button type="button"
                        onclick="showLoginAlert()"
                        class="mt-3 w-full bg-gray-400 text-white text-sm py-2.5 rounded-lg hover:bg-gray-500 transition">
                        Kirim Komentar
                    </button>
                </div>
            @endauth
        </div>
    </div>
</div>

<script>
function showLoginAlert() {
    alert('🔒 Silakan login terlebih dahulu untuk menulis komentar.');
    window.location.href = "{{ route('login') }}";
}
</script>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up { animation: fadeInUp 0.8s ease-in-out both; }

.scrollbar-thin::-webkit-scrollbar { width: 6px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
.scrollbar-thin::-webkit-scrollbar-track { background-color: #f8fafc; }

@media (max-width: 768px) {
    img { max-height: 280px !important; }
    .max-w-6xl { padding-left: 1rem; padding-right: 1rem; }
}
</style>
@endsection
