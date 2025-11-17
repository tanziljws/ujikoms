<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- penting biar mobile responsif -->
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center font-sans p-4">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg w-full max-w-sm sm:max-w-md md:max-w-lg">
        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 break-words">
                Halo, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-gray-500 mt-1 text-sm sm:text-base">Selamat datang di Dashboard kamu</p>
        </div>

        <!-- Menu -->
        <div class="space-y-3">
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.home') : route('user.home') }}"
               class="block text-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium px-4 py-3 rounded-lg shadow hover:shadow-md hover:scale-[1.02] transition transform text-sm sm:text-base">
                Pergi ke Halaman Home
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 text-white font-medium px-4 py-3 rounded-lg shadow hover:bg-red-600 hover:shadow-md hover:scale-[1.02] transition transform text-sm sm:text-base">
                    Logout
                </button>
            </form>
        </div>

        <!-- Footer kecil -->
        <div class="mt-6 text-xs sm:text-sm text-gray-400 text-center">
            &copy; {{ date('Y') }} SMKN4 Kota Bogor
        </div>
    </div>
</body>
</html>
