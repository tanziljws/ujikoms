let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    if (localStorage.getItem('pwaDismissed')) {
        console.log('User pernah menolak install, tidak tampil lagi.');
        return;
    }

    if (document.getElementById('installBtn')) return;

    const installBtn = document.createElement('button');
    installBtn.id = 'installBtn';
    installBtn.innerText = '📱 Install Hann Website';
    installBtn.classList.add(
        'fixed', 'top-5', 'right-5', // 🔹 posisi atas kanan
        'bg-blue-600', 'hover:bg-blue-700',
        'text-white', 'px-4', 'py-2', 'rounded-lg', 'shadow-lg', 'z-50', 'transition'
    );
    document.body.appendChild(installBtn);

    installBtn.addEventListener('click', async () => {
        installBtn.remove();
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;

        if (outcome === 'accepted') {
            console.log('✅ User menginstal aplikasi');
        } else {
            console.log('❌ User batal install');
            localStorage.setItem('pwaDismissed', 'true');
        }

        deferredPrompt = null;
    });
});
