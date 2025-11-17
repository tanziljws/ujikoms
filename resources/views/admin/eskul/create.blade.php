@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-center text-blue-600 mb-8">➕ Tambah Ekstrakurikuler</h2>

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-6">
        <form action="{{ route('admin.eskul.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Nama Eskul -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Eskul</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan nama eskul">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pembina -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pembina</label>
                <input type="text" name="pembina" value="{{ old('pembina') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan nama pembina">
                @error('pembina')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Tuliskan deskripsi eskul">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Foto</label>
                <input type="file" name="foto"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-between">
                <a href="{{ route('admin.eskul.index') }}"
                                          class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">⬅ Kembali</a>
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
