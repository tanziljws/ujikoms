<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle($id)
    {
        $photo = Photo::findOrFail($id);

        // 🔹 Jika user login
        if (auth()->check()) {
            $alreadyLiked = $photo->likes()->where('user_id', auth()->id())->exists();

            if ($alreadyLiked) {
                // Jika sudah like, maka unlike
                $photo->likes()->where('user_id', auth()->id())->delete();
            } else {
                // Jika belum, maka like
                $photo->likes()->create(['user_id' => auth()->id()]);
            }
        } 
        // 🔹 Jika guest (belum login)
        else {
            $likedPhotos = session('liked_photos', []);

            if (in_array($photo->id, $likedPhotos)) {
                // Jika sudah di-like sebelumnya → unlike
                $photo->decrement('guest_likes'); 
                $likedPhotos = array_diff($likedPhotos, [$photo->id]);
            } else {
                // Jika belum di-like → tambahkan
                $photo->increment('guest_likes');
                $likedPhotos[] = $photo->id;
            }

            // Simpan kembali ke session
            session(['liked_photos' => $likedPhotos]);
        }

        return back();
    }
}
