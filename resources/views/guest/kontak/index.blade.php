@extends('layouts.app')

@section('content')
<style>
    /* Animasi Fade In */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Efek diterapkan ke container utama */
    .fade-in {
        animation: fadeIn 1s ease-out;
    }

    /* Tambahan efek bertahap (stagger) untuk elemen-elemen dalam grid */
    .fade-in-delay-1 {
        animation: fadeIn 1s ease-out 0.2s both;
    }

    .fade-in-delay-2 {
        animation: fadeIn 1s ease-out 0.4s both;
    }
</style>

<div class="bg-white min-h-screen py-8 px-4 md:py-12 md:px-8 fade-in">
    <div class="w-full">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-blue-600 mb-6 md:mb-8 fade-in-delay-1">
            Hubungi Kami
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">

            <!-- Form Kontak -->
            <div class="fade-in-delay-1">
                <form method="POST" action="{{ route('kontak.kirim') }}">
                    @csrf

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @error('nama')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                               class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    @error('email')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    @error('pesan')
                        <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
                    @enderror
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Pesan</label>
                        <textarea name="pesan" rows="4" required
                                  class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old('pesan') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-500 text-white font-medium py-3 rounded-lg hover:bg-blue-600 transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Informasi Kontak -->
            <div class="bg-blue-50 rounded-xl p-6 md:p-8 flex flex-col justify-center shadow-md fade-in-delay-2">
                <h3 class="text-lg md:text-xl font-semibold text-blue-600 mb-4">Informasi Kontak</h3>
                <p class="text-gray-700 mb-2"><strong>Sekolah:</strong> SMKN 4 Kota Bogor</p>
                <p class="text-gray-700 mb-2"><strong>Email:</strong> smkn4bogor@example.com</p>
                <p class="text-gray-700 mb-2"><strong>Telepon:</strong> (0251) 123456</p>
                <p class="text-gray-700"><strong>Alamat:</strong> Jl. Raya Pajajaran No. 123, Kota Bogor</p>
            </div>

        </div>
    </div>
</div>
@endsection
 