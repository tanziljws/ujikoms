<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Menyimpan komentar baru dari user.
     */
    public function store(Request $request, $photoId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $photo = Photo::findOrFail($photoId);

        Comment::create([
            'photo_id' => $photo->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Menampilkan semua komentar (untuk admin / user tertentu)
     */
    public function index()
    {
        // Kalau user biasa: tampilkan komentar miliknya saja
        if (Auth::user()->role === 'user') {
            $comments = Comment::with(['user', 'photo'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        } else {
            // Kalau admin: tampilkan semua komentar
            $comments = Comment::with(['user', 'photo'])
                ->latest()
                ->get();
        }

        return view('admin.comment.index', compact('comments'));
    }

    /**
     * Menampilkan detail komentar
     */
    public function show($id)
    {
        $comment = Comment::with(['user', 'photo'])->findOrFail($id);
        return view('admin.comment.show', compact('comment'));
    }

    /**
     * Menghapus komentar
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Hapus hanya jika user pemilik atau admin
        if (Auth::user()->role === 'admin' || Auth::id() === $comment->user_id) {
            $comment->delete();
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Kamu tidak punya izin menghapus komentar ini.');
    }
}
