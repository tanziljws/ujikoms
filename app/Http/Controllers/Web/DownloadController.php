<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public function download($folder, $filename)
    {
        // Path ke folder di public/storage/
        $filePath = public_path("storage/{$folder}/{$filename}");

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            abort(404, "File tidak ditemukan di: {$filePath}");
        }

        // Kembalikan file untuk diunduh
        return response()->download($filePath);
    }
}
