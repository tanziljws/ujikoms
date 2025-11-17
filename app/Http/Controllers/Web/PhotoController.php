<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Menampilkan daftar foto (CRUD) untuk admin
     */
    public function index()
    {
        $photos = Photo::all();
        return view('admin.album.index', compact('photos'));
    }

    /**
     * Halaman album user -> semua foto
     */
    public function gallery()
    {
        // urutkan berdasarkan jumlah like terbanyak
        $photos = Photo::withCount('likes')->orderByDesc('likes_count')->latest()->get();
        return view('user.album.index', compact('photos'));
    }

    /**
     * ➕ Menampilkan satu foto secara detail (user)
     */
    public function show($id)
    {
        $photo = Photo::with(['likes', 'comments.user'])->findOrFail($id);
        return view('user.album.show', compact('photo'));
    }

    /**
     * Form tambah foto (admin)
     */
    public function create()
    {
        return view('admin.album.create');
    }

    /**
     * Simpan foto baru (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        Photo::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->route('admin.album.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    /**
     * Form edit foto (admin)
     */
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        return view('admin.album.edit', compact('photo'));
    }

    /**
     * Update data foto (admin)
     */
    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($photo->image && Storage::disk('public')->exists($photo->image)) {
                Storage::disk('public')->delete($photo->image);
            }

            $path = $request->file('image')->store('photos', 'public');
            $photo->image = $path;
        }

        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->save();

        return redirect()->route('admin.album.index')->with('success', 'Foto berhasil diperbarui');
    }

    /**
     * Hapus foto (admin)
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        if ($photo->image && Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()->route('admin.album.index')->with('success', 'Foto berhasil dihapus');
    }
    
}
