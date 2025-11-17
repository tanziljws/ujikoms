<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiService;

class ChatWebController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        return view('user.bantuan.index');
    }

    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $response = $this->geminiService->generateContent($request->message);

        return response()->json(['reply' => $response]);
    }
}
