<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

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

        $fullPath = Storage::disk('public')->path($filePath);

        // Untuk mobile, gunakan Response::download() yang lebih compatible
        return Response::download($fullPath, basename($filename), [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
