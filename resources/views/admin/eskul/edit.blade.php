@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-center text-green-600 mb-8">✏️ Edit Ekstrakurikuler</h2>

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-6">
        <form action="{{ route('admin.eskul.update', $eskul->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Eskul -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Eskul</label>
                <input type="text" name="nama" value="{{ old('nama', $eskul->nama) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <!-- Pembina -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pembina</label>
                <input type="text" name="pembina" value="{{ old('pembina', $eskul->pembina) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('deskripsi', $eskul->deskripsi) }}</textarea>
            </div>

            <!-- Foto -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Foto</label>
                @if($eskul->foto)
                    <img src="{{ asset('storage/'.$eskul->foto) }}" alt="{{ $eskul->nama }}" class="h-40 rounded-lg mb-3">
                @endif
                <input type="file" name="foto"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
            </div>

            <!-- Tombol -->
            <div class="flex justify-between">
                <a href="{{ route('admin.eskul.index') }}"
                                          class="inline-block mt-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition duration-200">⬅ Kembali</a>
                <button type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">💾 Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
