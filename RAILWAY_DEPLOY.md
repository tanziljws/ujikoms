# Railway Deployment Checklist

## Setup Database
✅ Database MySQL sudah dikonfigurasi di `.env`

## Setup Storage
**PENTING:** Jalankan command ini setelah deploy:
```bash
php artisan storage:link
```

Ini akan membuat symlink dari `public/storage` ke `storage/app/public` sehingga file bisa diakses.

## Environment Variables di Railway
Pastikan set di Railway dashboard:
- `DB_CONNECTION=mysql`
- `DB_HOST=switchyard.proxy.rlwy.net`
- `DB_PORT=38888`
- `DB_DATABASE=railway`
- `DB_USERNAME=root`
- `DB_PASSWORD=HvdwwzUZxbiELEsHKzEnPomoUuGguhHn`
- `APP_URL=https://ujikomm.up.railway.app`
- `APP_ENV=production`
- `APP_DEBUG=false`

## Post-Deploy Commands
Setelah deploy, jalankan:
```bash
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Troubleshooting

### 403 Errors pada Storage Files
- Pastikan `php artisan storage:link` sudah dijalankan
- Route fallback sudah dibuat di `routes/web.php` untuk handle jika symlink tidak bekerja
- Check file permissions di `storage/app/public`

### CORS Errors
- CORS sudah dikonfigurasi untuk allow semua origin (single domain)
- Service Worker sudah diperbaiki untuk handle origin mismatch

### Download Files 404
- Pastikan file ada di `storage/app/public/{folder}/{filename}`
- Route `/download/{folder}/{namafile}` sudah terdaftar

