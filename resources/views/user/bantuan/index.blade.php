@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 sm:py-10">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
            <h2 class="text-lg sm:text-xl font-semibold flex items-center gap-2">
                🤖 <span>Bantuan Chat AI</span>
            </h2>
            <span id="ai-status" class="text-xs sm:text-sm opacity-80 transition-all duration-300">Online</span>
        </div>

        <!-- Chat Box -->
        <div id="chat-box" 
             class="bg-gray-50 h-[400px] sm:h-[480px] overflow-y-auto px-4 sm:px-6 py-3 sm:py-4 space-y-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <div class="flex justify-center text-gray-400 text-sm mt-2">
                💬 Mulai percakapan dengan AI
            </div>
        </div>

        <!-- Input Form -->
        <form id="chat-form" class="border-t bg-white p-3 sm:p-4 flex items-center space-x-2 sm:space-x-3">
            <input 
                type="text" 
                id="message" 
                name="message" 
                placeholder="Ketik pesan kamu di sini..." 
                class="flex-1 border border-gray-300 rounded-full px-3 sm:px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition w-full">
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-full font-medium text-sm sm:text-base hover:bg-blue-700 transition-all duration-200">
                Kirim
            </button>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const msgInput = document.getElementById('message');
    const chatBox = document.getElementById('chat-box');
    const aiStatus = document.getElementById('ai-status');
    const msg = msgInput.value.trim();
    if (!msg) return;

    // Tampilkan pesan user (bubble kanan)
    chatBox.innerHTML += `
        <div class="flex justify-end animate-fade-in">
            <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-none max-w-[80%] sm:max-w-[75%] shadow-sm break-words text-sm sm:text-base">
                ${msg}
            </div>
        </div>
    `;
    msgInput.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;

    // Ganti status jadi mengetik
    aiStatus.textContent = "Mengetik...";

    // Kirim ke server
    const res = await fetch("{{ route('bantuan.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message: msg })
    });

    const data = await res.json();

    // Simulasikan delay mengetik biar realistis
    setTimeout(() => {
        // Balasan AI (bubble kiri)
        chatBox.innerHTML += `
            <div class="flex justify-start animate-fade-in">
                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-2xl rounded-bl-none max-w-[80%] sm:max-w-[75%] shadow-sm break-words text-sm sm:text-base">
                    ${data.reply}
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        // Kembalikan status jadi online
        aiStatus.textContent = "Online";
    }, 600);
});
</script>

{{-- Styling --}}
<style>
/* Animasi */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.4s ease-out both;
}

/* Scrollbar halus */
.scrollbar-thin::-webkit-scrollbar { width: 6px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
.scrollbar-thin::-webkit-scrollbar-track { background-color: #f8fafc; }

/* Responsif tambahan */
@media (max-width: 640px) {
    #chat-box { height: 400px; }
    button[type="submit"] { padding: 0.5rem 1rem; }
}
</style>
@endsection
