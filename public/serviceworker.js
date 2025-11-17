let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    // Mencegah Chrome langsung menampilkan banner default
    e.preventDefault();
    deferredPrompt = e;

    // Cegah tombol duplikat
    if (document.getElementById('installBtn')) return;

    // Buat tombol install kustom
    const installBtn = document.createElement('button');
    installBtn.id = 'installBtn';
    installBtn.innerText = '📲 Install Hann Website';
    installBtn.classList.add(
        'fixed', 'bottom-5', 'right-5', 'bg-blue-600', 'hover:bg-blue-700',
        'text-white', 'px-4', 'py-2', 'rounded-lg', 'shadow-lg', 'z-50', 'transition'
    );

    document.body.appendChild(installBtn);

    // Event klik tombol
    installBtn.addEventListener('click', async () => {
        installBtn.remove();
        deferredPrompt.prompt();

        const { outcome } = await deferredPrompt.userChoice;
        console.log(`User response: ${outcome}`);

        // Reset variabel setelah digunakan
        deferredPrompt = null;
    });
});

// Opsional: tampilkan pesan kalau sudah terpasang
window.addEventListener('appinstalled', () => {
    console.log('PWA Hann Website berhasil diinstal!');
});
