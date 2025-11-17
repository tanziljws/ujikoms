<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Photo; // ✅ tambahin ini biar bisa pakai model Photo

class HomeController extends Controller
{

     
    public function adminHome()
    {
        return view('admin.home');
    }

    public function userHome()
    {
        // ambil maksimal 8 foto terbaru untuk ditampilkan di home
        $photos = Photo::latest()->take(8)->get();

        return view('user.home', compact('photos'));
    }
}
