@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 md:px-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-blue-600">💬 Komentar Saya</h2>
        <a href="{{ route('user.album.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-md transition">
            ← Kembali ke Album
        </a>
    </div>

    {{-- Pesan sukses / error --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 shadow-sm">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Jika belum ada komentar --}}
    @if($comments->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            Kamu belum menulis komentar apa pun.
        </div>
    @else
        {{-- Daftar komentar --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($comments as $comment)
                <div class="bg-white rounded-xl shadow-md p-5 flex flex-col justify-between hover:shadow-xl transition">
                    <div>
                        <p class="text-gray-700 text-base mb-3">"{{ $comment->content }}"</p>

                        <div class="text-sm text-gray-500">
                            <span>📸 Pada foto: </span>
                            <a href="{{ route('user.album.show', $comment->photo->id) }}" 
                               class="text-blue-600 hover:underline">
                                {{ $comment->photo->title ?? 'Tanpa Judul' }}
                            </a>
                        </div>

                        <p class="text-xs text-gray-400 mt-2">🕒 {{ $comment->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- Tombol hapus komentar --}}
                    <form action="{{ route('photo.comment.delete', $comment->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus komentar ini?')" class="mt-4 text-right">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm transition">
                            🗑 Hapus
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
