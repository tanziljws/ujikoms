<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- penting untuk mobile -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
      style="background-image: url('https://lh5.googleusercontent.com/viO81VtxbwzqFFEa0G7q7o-ZNJAZ2s0H0-4Ou5ZgvGHdfe80cyw0rgQTe2WUdmxT=s1134-k-no');">

    <!-- Overlay gelap agar form lebih jelas -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <!-- Card Register -->
    <div class="relative z-10 bg-white/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-xl w-11/12 max-w-md mx-auto">
        
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="data:image/jpeg;base64,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" alt="Logo" class="mx-auto mb-4 w-24 h-24 rounded-full object-cover" 
                 alt="Logo" 
                 class="w-20 sm:w-24 md:w-28 lg:w-32 h-auto object-contain">
        </div>

        <!-- Judul -->
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-blue-600 mb-6">
            Daftar Akun Baru
        </h2>

        <!-- Form Register -->
        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" required
                       placeholder="Masukkan nama lengkap"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm sm:text-base">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                       placeholder="Masukkan email"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm sm:text-base">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                       placeholder="Buat password"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm sm:text-base">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       placeholder="Ulangi password"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm sm:text-base">
            </div>

            <!-- Tombol -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition text-sm sm:text-base">
                Daftar
            </button>
        </form>

        <!-- Link ke login -->
        <p class="mt-4 text-center text-xs sm:text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
