<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // ✅ pakai base Controller
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoApiController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar foto',
            'data' => $photos
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        $photo = Photo::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil ditambahkan!',
            'data' => $photo
        ], 201);
    }

    public function show($id)
    {
        $photo = Photo::find($id);

        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Foto tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $photo
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $photo = Photo::find($id);

        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Foto tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($photo->image && Storage::disk('public')->exists($photo->image)) {
                Storage::disk('public')->delete($photo->image);
            }

            $path = $request->file('photo')->store('photos', 'public');
            $photo->image = $path;
        }

        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diperbarui',
            'data' => $photo
        ], 200);
    }

    public function destroy($id)
    {
        $photo = Photo::find($id);

        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Foto tidak ditemukan'
            ], 404);
        }

        if ($photo->image && Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus'
        ], 200);
    }
}
