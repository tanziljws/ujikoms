@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Edit Guru</h2>
    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block">Nama Guru</label>
            <input type="text" name="nama" value="{{ $guru->nama }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block">Mata Pelajaran</label>
            <input type="text" name="mapel" value="{{ $guru->mapel }}" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block">Deskripsi</label>
            <textarea name="deskripsi" class="w-full border rounded p-2">{{ $guru->deskripsi }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block">Foto</label>
            <input type="file" name="foto" class="w-full border rounded p-2">
            @if($guru->foto)
                <img src="{{ asset('storage/'.$guru->foto) }}" class="h-24 mt-2 rounded">
            @endif
        </div>
         <a href="{{ route('admin.guru.index') }}"
                                          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">⬅ Kembali</a>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
    </form>
</div>
@endsection
