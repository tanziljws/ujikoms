@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h4 class="text-xl font-bold mb-4 text-center text-blue-600">✏️ Edit Foto</h4>
        
        <form action="{{ route('admin.album.update', $photo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Judul Foto --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Foto</label>
                <input type="text" name="title" id="title" value="{{ old('title', $photo->title) }}"
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>

            {{-- Foto Lama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Foto Sekarang</label>
                @if($photo->image && file_exists(storage_path('app/public/'.$photo->image)))
                    <img src="{{ asset('storage/'.$photo->image_path) }}" 
                         alt="{{ $photo->title }}" 
                         class="h-40 rounded-lg object-cover mt-2">
                @else
                    <div class="h-40 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 mt-2">
                        📷 Tidak ada gambar
                    </div>
                @endif
            </div>

            {{-- Upload Foto Baru --}}
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Ganti Foto (opsional)</label>
                <input type="file" name="image" id="image"
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description', $photo->description) }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-center space-x-3 pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md">
                    💾 Update Foto
                </button>
                <a href="{{ route('admin.album.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ↩️ Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
