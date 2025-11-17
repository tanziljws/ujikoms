<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($folder, $filename)
    {
        // Path ke file di storage
        $filePath = "{$folder}/{$filename}";

        // Cek apakah file ada di storage
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, "File tidak ditemukan");
        }

        // Kembalikan file untuk diunduh
        return Storage::disk('public')->download($filePath);
    }
}
