@extends('layouts.app')

@section('content')
<style>
    /* ===== Fade In Animation ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
        opacity: 0;
        animation: fadeInUp 0.8s forwards;
    }
    @foreach(range(1, 50) as $i)
        .fade-in-{{ $i }} { animation-delay: {{ $i * 0.1 }}s; }
    @endforeach
</style>

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-6 mt-6 fade-in fade-in-1">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 border-b pb-3 fade-in fade-in-2">💬 Manajemen Komentar</h2>

    {{-- ✅ Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300 fade-in fade-in-3">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300 fade-in fade-in-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- 🔍 Kolom Pencarian --}}
    <div class="flex justify-center mb-6 fade-in fade-in-4">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchComment" 
                placeholder="Cari komentar berdasarkan user, isi komentar, atau foto..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-white border border-gray-200 shadow-md 
                    focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 
                    text-gray-700 placeholder-gray-400"
            >
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
        </div>
    </div>

    {{-- ✅ Versi Desktop --}}
    <div class="hidden md:block overflow-x-auto fade-in fade-in-5">
        <table id="commentTable" class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                <tr>
                    <th class="py-3 px-5 text-left rounded-tl-xl">#</th>
                    <th class="py-3 px-5 text-left">User</th>
                    <th class="py-3 px-5 text-left">Foto</th>
                    <th class="py-3 px-5 text-left">Komentar</th>
                    <th class="py-3 px-5 text-center rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comments as $comment)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out comment-row"
                        data-user="{{ strtolower($comment->user->name ?? '') }}"
                        data-content="{{ strtolower($comment->content) }}"
                        data-photo="{{ strtolower($comment->photo->title ?? '') }}">
                        <td class="py-3 px-5 font-medium text-gray-600">{{ $loop->iteration }}</td>

                        <td class="py-3 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 flex items-center justify-center rounded-full 
                                    {{ $comment->user->role === 'admin' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $comment->user->name ?? 'User tidak ditemukan' }}</p>
                                    <span class="text-xs text-gray-500">{{ $comment->user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 px-5">
                            <div>
                                <p class="font-medium text-gray-800">{{ $comment->photo->title ?? 'Foto tidak ditemukan' }}</p>
                                <span class="text-xs text-gray-400">
                                    ID: {{ $comment->photo->id ?? '-' }}
                                </span>
                            </div>
                        </td>

                        <td class="py-3 px-5 text-gray-700">
                            {{ $comment->content }}
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                            </div>
                        </td>

                        <td class="py-3 px-5 text-center">
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="button"
                                    class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs shadow-sm transition duration-200">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500 italic">
                            Belum ada komentar yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Versi Mobile --}}
    <div id="commentGrid" class="grid gap-4 md:hidden overflow-y-auto max-h-[70vh] pr-2 fade-in fade-in-6">
        @forelse ($comments as $comment)
            <div class="bg-white border rounded-lg shadow-md p-4 comment-card"
                data-user="{{ strtolower($comment->user->name ?? '') }}"
                data-content="{{ strtolower($comment->content) }}"
                data-photo="{{ strtolower($comment->photo->title ?? '') }}">
                <h3 class="font-bold text-lg text-blue-700">{{ $comment->user->name ?? 'User tidak ditemukan' }}</h3>
                <p class="text-sm text-gray-600 mb-1">{{ $comment->user->email ?? '-' }}</p>
                <p class="text-sm text-gray-700"><strong>Foto:</strong> {{ $comment->photo->title ?? '-' }}</p>
                <p class="mt-2 text-gray-800">{{ $comment->content }}</p>
                <div class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</div>
                <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="mt-3 delete-form">
                    @csrf @method('DELETE')
                    <button type="button"
                        class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs transition">
                        Hapus
                    </button>
                </form>
            </div>
        @empty
            <p class="text-center text-gray-500 fade-in fade-in-50">Belum ada komentar</p>
        @endforelse
    </div>
</div>

{{-- ✅ Script SweetAlert & Search --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 🔍 Searching
    const input = document.getElementById('searchComment');
    const rows = document.querySelectorAll('.comment-row');
    const cards = document.querySelectorAll('.comment-card');

    input.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        rows.forEach(row => {
            const user = row.dataset.user;
            const content = row.dataset.content;
            const photo = row.dataset.photo;
            row.style.display = (user.includes(query) || content.includes(query) || photo.includes(query)) ? '' : 'none';
        });
        cards.forEach(card => {
            const user = card.dataset.user;
            const content = card.dataset.content;
            const photo = card.dataset.photo;
            card.style.display = (user.includes(query) || content.includes(query) || photo.includes(query)) ? '' : 'none';
        });
    });

    // 🗑️ Pop-up konfirmasi hapus pakai SweetAlert
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: ' Hapus Komentar?',
                text: 'Komentar yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'rounded-full px-5 py-2 font-semibold',
                    cancelButton: 'rounded-full px-5 py-2 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
