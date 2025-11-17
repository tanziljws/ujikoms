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
        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
        
        // Untuk mobile, gunakan response()->file() dengan headers yang benar
        return Response::file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . basename($filename) . '"',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
