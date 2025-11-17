<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KontakController extends Controller
{
    public function kirim(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        // Data yang akan dikirim
        $data = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'pesan' => $validated['pesan'],
        ];

        // Kirim email ke alamat tujuan
        Mail::send('emails.kontak', $data, function ($message) use ($data) {
            $message->to('muhammadraihan9222@gmail.com')
                    ->subject('Pesan Baru dari Form Kontak')
                    ->replyTo($data['email'], $data['nama']);
        });

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pesan kamu berhasil dikirim! 🎉');
    }
}
