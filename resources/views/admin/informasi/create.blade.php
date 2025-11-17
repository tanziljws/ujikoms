@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Tambah Informasi</h2>

    <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Judul</label>
            <input type="text" name="judul" class="w-full border rounded-lg p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Deskripsi</label>
            <textarea name="deskripsi" rows="5" class="w-full border rounded-lg p-2 mt-1" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Isi informasi</label>
            <textarea name="isi_informasi" rows="5" class="w-full border rounded-lg p-2 mt-1" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Foto</label>
            <input type="file" name="foto" class="w-full border rounded-lg p-2 mt-1">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
         <a href="{{ route('admin.informasi.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Kembali
                </a>
    </form>
</div>
@endsection
