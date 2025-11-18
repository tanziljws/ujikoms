<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\PhotoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\GuruController;
use App\Http\Controllers\Web\EskulController;
use App\Http\Controllers\Web\InformasiController;
use App\Http\Controllers\Web\ChatWebController;
use App\Http\Controllers\Web\LikeController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\KontakController;
use App\Http\Controllers\Web\DownloadController;




// Handle OPTIONS request untuk CORS preflight
Route::options('/manifest.json', function () {
    return response('', 200, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type',
        'Access-Control-Max-Age' => '86400',
    ]);
});

Route::options('/serviceworker.js', function () {
    return response('', 200, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type',
    ]);
});

// Route untuk manifest.json dengan CORS headers
Route::get('/manifest.json', function () {
    $filePath = public_path('manifest.json');
    
    if (!file_exists($filePath)) {
        return response()->json(['error' => 'Not found'], 404, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET',
        ]);
    }
    
    $content = file_get_contents($filePath);
    
    return response($content, 200, [
        'Content-Type' => 'application/manifest+json',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type',
        'Access-Control-Max-Age' => '86400',
    ]);
})->name('manifest');

// Route untuk serviceworker.js dengan CORS headers
Route::get('/serviceworker.js', function () {
    $filePath = public_path('serviceworker.js');
    
    if (!file_exists($filePath)) {
        return response()->json(['error' => 'Not found'], 404, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET',
        ]);
    }
    
    $content = file_get_contents($filePath);
    
    return response($content, 200, [
        'Content-Type' => 'application/javascript',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Service-Worker-Allowed' => '/',
        'Access-Control-Allow-Headers' => 'Content-Type',
    ]);
})->name('serviceworker');

// Route untuk download file
Route::get('/download/{folder}/{namafile}', [DownloadController::class, 'download'])
     ->name('photo.download');

// Route untuk serve storage files jika symlink tidak bekerja (fallback)
Route::get('/storage/{path}', function ($path) {
    // Handle path yang tidak lengkap (misalnya "1" menjadi "photos/1")
    if (!str_contains($path, '/') && is_numeric($path)) {
        $path = 'photos/' . $path;
    }
    
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        // Return 404 dengan CORS headers
        return response()->json(['error' => 'File not found'], 404, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET',
        ]);
    }
    
    $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => 'Content-Type',
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.serve');






/*
|--------------------------------------------------------------------------
| ROUTE KONTAK
|--------------------------------------------------------------------------
*/
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

/*
|--------------------------------------------------------------------------
| ROUTE KOMENTAR & LIKE (USER)
|--------------------------------------------------------------------------
*/
// Like/unlike foto - bisa diakses oleh user dan guest (tidak perlu auth)
Route::post('/photo/{photo}/like', [LikeController::class, 'toggle'])->name('photo.like');

// Komentar hanya untuk user yang login
Route::middleware('auth')->group(function () {
    // Simpan komentar
    Route::post('/photo/{photo}/comment', [CommentController::class, 'store'])->name('photo.comment');
});

/*
|--------------------------------------------------------------------------
| FITUR BANTUAN (CHATBOT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/bantuan', [ChatWebController::class, 'index'])->name('user.bantuan.index');
    Route::post('/bantuan/send', [ChatWebController::class, 'send'])->name('bantuan.send');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| HALAMAN GUEST (UMUM)
|--------------------------------------------------------------------------
*/
Route::prefix('/')->group(function () {
    Route::view('/', 'guest.index')->name('guest.home');
    Route::view('/tentang', 'guest.tentang.index')->name('guest.tentang.index');
    Route::view('/kontak', 'guest.kontak.index')->name('guest.kontak.index');

    // Eskul (hanya lihat)
    Route::get('/eskul', [EskulController::class, 'indexGuest'])->name('guest.eskul.index');
Route::get('/eskul/{eskul}', [EskulController::class, 'showguest'])->name('guest.eskul.show');


    // Guru (hanya lihat)
    Route::get('/guru', [GuruController::class, 'indexGuest'])->name('guest.guru.index');

    // Informasi Sekolah (hanya lihat)
    Route::get('/informasi', [InformasiController::class, 'indexGuest'])->name('guest.informasi.index');
Route::get('/informasi/{informasi}', [InformasiController::class, 'showguest'])->name('guest.informasi.show');


    // Galeri Foto
    Route::get('/photo/{id}', [PhotoController::class, 'show'])->name('user.photo.show');

});

/*
|--------------------------------------------------------------------------
| AUTHENTIKASI
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/redirect-home', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('guest.home');
})->name('redirect.home');

/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'userHome'])->name('user.home');

    // Album / Galeri Foto User
    Route::get('/album', [PhotoController::class, 'gallery'])->name('user.album.index');
    Route::get('/album/{id}', [PhotoController::class, 'show'])->name('user.album.show');

    // Guru, Eskul, Informasi
    Route::get('/guru', [GuruController::class, 'indexUser'])->name('user.guru.index');
Route::get('/guru/{guru}', [GuruController::class, 'show'])->name('user.guru.show');

    Route::get('/eskul', [EskulController::class, 'indexUser'])->name('user.eskul.index');
Route::get('/eskul/{eskul}', [EskulController::class, 'show'])->name('user.eskul.show');

    Route::get('/informasi', [InformasiController::class, 'indexUser'])->name('user.informasi.index');
Route::get('/informasi/{informasi}', [InformasiController::class, 'show'])->name('user.informasi.show');


    Route::view('/tentang', 'user.tentang.index')->name('user.tentang.index');
    Route::view('/kontak', 'user.kontak.index')->name('user.kontak.index');
    
    
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home');

    // CRUD Guru
    Route::get('/guru', [GuruController::class, 'indexAdmin'])->name('admin.guru.index');
    Route::get('/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
    Route::post('/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/guru/{guru}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/guru/{guru}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/guru/{guru}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    // CRUD Eskul
    Route::get('/eskul', [EskulController::class, 'indexAdmin'])->name('admin.eskul.index');
    Route::get('/eskul/create', [EskulController::class, 'create'])->name('admin.eskul.create');
    Route::post('/eskul', [EskulController::class, 'store'])->name('admin.eskul.store');
    Route::get('/eskul/{eskul}/edit', [EskulController::class, 'edit'])->name('admin.eskul.edit');
    Route::put('/eskul/{eskul}', [EskulController::class, 'update'])->name('admin.eskul.update');
    Route::delete('/eskul/{eskul}', [EskulController::class, 'destroy'])->name('admin.eskul.destroy');

    // CRUD Informasi Sekolah
    Route::get('/informasi', [InformasiController::class, 'indexAdmin'])->name('admin.informasi.index');
    Route::get('/informasi/create', [InformasiController::class, 'create'])->name('admin.informasi.create');
    Route::post('/informasi', [InformasiController::class, 'store'])->name('admin.informasi.store');
    Route::get('/informasi/{informasi}/edit', [InformasiController::class, 'edit'])->name('admin.informasi.edit');
    Route::put('/informasi/{informasi}', [InformasiController::class, 'update'])->name('admin.informasi.update');
    Route::delete('/informasi/{informasi}', [InformasiController::class, 'destroy'])->name('admin.informasi.destroy');

    // CRUD Album (Foto)
    Route::get('/album', [PhotoController::class, 'index'])->name('admin.album.index');
    Route::get('/album/create', [PhotoController::class, 'create'])->name('admin.album.create');
    Route::post('/album', [PhotoController::class, 'store'])->name('admin.album.store');
    Route::get('/album/{id}/edit', [PhotoController::class, 'edit'])->name('admin.album.edit');
    Route::put('/album/{id}', [PhotoController::class, 'update'])->name('admin.album.update');
    Route::delete('/album/{id}', [PhotoController::class, 'destroy'])->name('admin.album.destroy');

    // 🔹 Manajemen Komentar (Admin)
    Route::get('/comments', [CommentController::class, 'index'])->name('admin.comment.index');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('admin.comment.destroy');

    // Halaman Tentang & Kontak Admin
    Route::view('/tentang', 'admin.tentang.index')->name('admin.tentang.index');
    Route::view('/kontak', 'admin.kontak.index')->name('admin.kontak.index');
    Route::get('/user', [UserController::class, 'index'])->name('admin.users.index');

    // Manajemen Akun
    Route::resource('/users', UserController::class);
    Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    
});

// ==================== KOMENTAR ====================
Route::middleware(['auth'])->group(function () {
    // Simpan komentar
    Route::post('/photo/{photo}/comment', [CommentController::class, 'store'])
        ->name('photo.comment');

    // Hapus komentar
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])
        ->name('comment.destroy');
});