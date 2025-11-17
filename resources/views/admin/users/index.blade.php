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

    /* ===== Scroll Reveal (Mobile) ===== */
    .reveal-hidden {
        opacity: 0;
        transform: translateY(25px);
        transition: all 0.8s ease-out;
    }

    .reveal-show {
        opacity: 1;
        transform: translateY(0);
    }

    /* ===== Responsif Table ===== */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 0.75rem;
        text-align: left;
        white-space: nowrap;
    }

    /* Scroll responsif */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ===== Card Responsif ===== */
    @media (max-width: 768px) {
        .table-container { display: none; }
        #userGrid { display: grid; }
    }

    @media (min-width: 769px) {
        #userGrid { display: none; }
    }

    /* ===== Mobile Fix Padding ===== */
    @media (max-width: 640px) {
        .max-w-7xl {
            padding: 1rem !important;
        }
    }
</style>

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-4 sm:p-6 mt-6 fade-in fade-in-1">
    <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 mb-6 border-b pb-3 fade-in fade-in-2 text-center sm:text-left">
        👥 Manajemen Akun
    </h2>

    {{-- ✅ Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300 fade-in fade-in-3 text-sm sm:text-base">
            {{ session('success') }}
        </div>
    @elseif(session('warning'))
        <div class="mb-4 p-4 rounded-lg bg-yellow-100 text-yellow-700 border border-yellow-300 fade-in fade-in-3 text-sm sm:text-base">
            {{ session('warning') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300 fade-in fade-in-3 text-sm sm:text-base">
            {{ session('error') }}
        </div>
    @endif

    {{-- 🔍 Pencarian --}}
    <div class="flex justify-center mb-6 fade-in fade-in-4">
        <div class="relative w-full sm:w-2/3 lg:w-1/2">
            <input 
                type="text" 
                id="searchUser" 
                placeholder="Cari pengguna berdasarkan nama atau email..." 
                class="w-full px-5 py-3 pl-12 rounded-full bg-white border border-gray-200 shadow-md 
                       focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-300 
                       text-gray-700 placeholder-gray-400 text-sm sm:text-base"
            >
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
            </svg>
        </div>
    </div>

    {{-- ✅ Desktop Table --}}
    <div class="table-container hidden md:block overflow-x-auto fade-in fade-in-5">
        <table id="userTable" class="min-w-full border border-gray-200 rounded-lg text-sm sm:text-base">
            <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 font-semibold">Nama</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 text-center font-semibold">Role</th>
                    <th class="px-6 py-3 text-center font-semibold">Status</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition fade-in fade-in-{{ $index + 5 }} user-row"
                        data-nama="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}">
                        <td class="px-6 py-3">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            @if($user->is_active)
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center space-x-2">
                            <a href="{{ route('users.edit', $user->id) }}" 
                               class="inline-block px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs transition">
                                Edit
                            </a>
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="inline-block px-3 py-1 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg text-xs transition">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline delete-form">
                                @csrf @method('DELETE')
                                <button type="button"
                                    class="delete-btn inline-block px-3 py-1 bg-gray-700 hover:bg-gray-800 text-white rounded-lg text-xs transition"
                                    data-user="{{ $user->name }}">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500 fade-in fade-in-50">Belum ada data user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Mobile Cards --}}
    <div id="userGrid" class="grid grid-cols-1 gap-4 fade-in fade-in-5">
        @forelse ($users as $index => $user)
            <div class="bg-white border rounded-lg shadow-md p-4 user-card"
                 data-nama="{{ strtolower($user->name) }}"
                 data-email="{{ strtolower($user->email) }}">
                <h3 class="font-bold text-lg text-blue-700">{{ $user->name }}</h3>
                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                <p class="mt-1 text-sm">
                    <span class="font-semibold">Role:</span>
                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
                <p class="mt-1 text-sm">
                    <span class="font-semibold">Status:</span>
                    @if($user->is_active)
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Nonaktif</span>
                    @endif
                </p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('users.edit', $user->id) }}" 
                       class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs transition">
                        Edit
                    </a>
                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="px-3 py-1 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg text-xs transition">
                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form">
                        @csrf @method('DELETE')
                        <button type="button" 
                            class="delete-btn px-3 py-1 bg-gray-700 hover:bg-gray-800 text-white rounded-lg text-xs transition"
                            data-user="{{ $user->name }}">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 fade-in fade-in-50">Belum ada data user</p>
        @endforelse
    </div>

    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>
</div>

{{-- 🔍 Search --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchUser');
    const rows = document.querySelectorAll('.user-row');
    const cards = document.querySelectorAll('.user-card');

    input.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.dataset.nama;
            const email = row.dataset.email;
            row.style.display = (nama.includes(query) || email.includes(query)) ? '' : 'none';
        });

        cards.forEach(card => {
            const nama = card.dataset.nama;
            const email = card.dataset.email;
            card.style.display = (nama.includes(query) || email.includes(query)) ? '' : 'none';
        });
    });
});
</script>

{{-- ✨ Scroll Reveal --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (window.innerWidth < 768) {
        const cards = document.querySelectorAll(".user-card");
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("reveal-show");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        cards.forEach(card => {
            card.classList.add("reveal-hidden");
            observer.observe(card);
        });
    }
});
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            const userName = this.dataset.user;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `User "${userName}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endsection
