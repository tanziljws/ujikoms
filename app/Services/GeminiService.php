<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('OPENROUTER_API_KEY');

        // Model Gemini yang VALID & MURAH
        $this->model = 'google/gemini-2.5-flash-lite-preview-09-2025';

    }

    public function generateContent($prompt)
    {
        $url = 'https://openrouter.ai/api/v1/chat/completions';

        if (empty($this->apiKey)) {
            return '❌ API Key tidak ditemukan di .env (cek OPENROUTER_API_KEY).';
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($url, [
            'model' => $this->model,
            'max_tokens' => 2048,
            'messages' => [
    [
        'role' => 'system',
        'content' => 'Jawablah seperti percakapan chat biasa, santai, ringkas, dan langsung ke inti. Jangan terlalu formal, dan jangan pakai format markdown kecuali dibutuhkan.'
    ],
    [
        'role' => 'user',
        'content' => $prompt
    ]
]

        ]);

        if ($response->failed()) {
            return '❌ Error API (' . $response->status() . '): ' . $response->body();
        }

        return $response->json('choices.0.message.content') ?? '⚠️ Tidak ada respons dari AI.';
    }
}
