<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Sekolah Digital</title>

    <!-- ✅ TailwindCSS via CDN (aman untuk dev/test) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ✅ PWA Configuration -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#3b82f6">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Hann Website">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">

    <script>
        // Register Service Worker untuk PWA
        if ('serviceWorker' in navigator && window.location.protocol !== 'file:') {
            window.addEventListener('load', async () => {
                try {
                    const swUrl = '{{ asset('serviceworker.js') }}';
                    if (swUrl.startsWith(window.location.origin)) {
                        const reg = await navigator.serviceWorker.register(swUrl);
                        console.log('✅ Service Worker terdaftar:', reg);
                    }
                } catch (err) {
                    console.warn('Service Worker tidak tersedia:', err.message);
                }
            });
        }
    </script>

    <style>
        /* === Global Styling === */
        :root {
            --primary: #2563eb;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        body {
            background-color: var(--light);
        }

        .gallery-item {
            transition: all 0.3s ease;
        }
        .gallery-item:hover {
            transform: scale(1.05) translateY(-4px);
            box-shadow: 0 15px 20px -5px rgba(0, 0, 0, 0.1);
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translate(-50%, 20px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        .fade-in {
            animation: fade-in 0.6s ease-out;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    {{-- ✅ Navbar --}}
    @include('components.navbar')

    {{-- ✅ Konten --}}
    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- ✅ Footer --}}
    @include('components.footer')
    @include('components.lightbox')

    @stack('scripts')
    @yield('scripts')

    <!-- ✅ PWA Install Popup -->
    <script>
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Cegah popup ganda
            if (document.getElementById('installPopup')) return;

            // Kalau user udah nolak, jangan tampilkan lagi
            if (localStorage.getItem('pwaDismissed')) return;

            // === Buat Popup Install ===
            const popup = document.createElement('div');
            popup.id = 'installPopup';
            popup.className = `
                fixed bottom-8 left-1/2 -translate-x-1/2 fade-in
                bg-white rounded-2xl shadow-2xl p-5 z-50 text-center
                w-11/12 max-w-sm border border-gray-200
            `;
            popup.innerHTML = `
                <h3 class="text-lg font-semibold text-gray-800 mb-2">📲 Install Hann Website</h3>
                <p class="text-gray-600 mb-4">Tambahkan ke layar utama agar lebih cepat diakses!</p>
                <div class="flex justify-center gap-3">
                    <button id="installNow" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">Pasang</button>
                    <button id="dismissInstall" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">Nanti</button>
                </div>
            `;
            document.body.appendChild(popup);

            // === Tombol "Pasang" ditekan ===
            document.getElementById('installNow').addEventListener('click', async () => {
                popup.remove();
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome !== 'accepted') localStorage.setItem('pwaDismissed', 'true');
                deferredPrompt = null;
            });

            // === Tombol "Nanti" ditekan ===
            document.getElementById('dismissInstall').addEventListener('click', () => {
                localStorage.setItem('pwaDismissed', 'true');
                popup.classList.add('opacity-0');
                setTimeout(() => popup.remove(), 400);
            });
        });
    </script>

<!-- =================== SWEETALERT UNTUK ALERT AKSI USER =================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // =================== FLASH MESSAGE ===================
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2563eb'
        });
    @endif

    @if (session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: '{{ session('warning') }}',
            confirmButtonColor: '#f59e0b'
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626'
        });
    @endif

    // =================== SCROLL REVEAL & SEARCH ===================
    const searchInput = document.getElementById('searchInput');
    const photoCards = document.querySelectorAll('.photo-card');

    // 🔍 Fitur pencarian
    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase().trim();

            photoCards.forEach(card => {
                const title = card.getAttribute('data-title');
                const description = card.getAttribute('data-description');

                if (title.includes(query) || description.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // ✨ Efek Scroll Reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('reveal-visible');
                }, index * 150);
            }
        });
    }, { threshold: 0.2 });

    photoCards.forEach(card => observer.observe(card));
});

// =================== USER GUEST ALERT ===================
function needLogin() {
    Swal.fire({
        icon: 'warning',
        title: 'Akses Ditolak',
        text: 'Silakan login terlebih dahulu untuk mengakses fitur ini.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3b82f6'
    });
}

// =================== KONFIRMASI HAPUS FOTO ADMIN ===================
function confirmDelete(event, formId) {
    event.preventDefault();

    Swal.fire({
        title: 'Yakin ingin menghapus foto ini?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>

</body>
</html>
