@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h4 class="text-xl font-bold mb-4 text-center text-blue-600">➕ Tambah Foto Baru</h4>

        {{-- tampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- tampilkan pesan sukses jika ada --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.album.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Foto</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('title') border-red-500 @enderror" required>
                @error('title')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Upload Foto</label>
                <input type="file" name="photo" id="photo"
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('photo') border-red-500 @enderror" required>
                @error('photo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-center space-x-3 pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md">
                    Simpan Foto
                </button>
                <a href="{{ route('admin.album.index') }}"
                   class="bg-gray-500 hover:bg-gray.-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
