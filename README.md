# Atom Visi Indonesia — Website

Website institusi riset Atom Visi Indonesia, dibangun dengan Laravel + Livewire (frontend publik) dan Filament (admin panel).

## Daftar Isi

- [Tutorial Deploy ke VPS](#tutorial-deploy-ke-vps)
- [Tutorial Setup Scheduler (Cron)](#tutorial-setup-scheduler-cron)
- [Masalah Umum & Solusinya](#masalah-umum--solusinya)

---

## Tutorial Deploy ke VPS

Asumsi: VPS Ubuntu dengan Nginx, PHP 8.3, MySQL, Composer, dan Node.js sudah terpasang.

### 1. Clone project

```bash
cd /var/www
git clone <url-repo> atomvisi.com
cd atomvisi.com
```

### 2. Install dependencies

```bash
composer install --no-dev --optimize-autoloader
npm install
```

### 3. Konfigurasi `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`, isi minimal:

```env
APP_NAME="Atom Visi Indonesia"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-asli-anda.com   # WAJIB persis sama dengan domain yang diakses browser

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

MAIL_ADMIN_ADDRESS=admin@domain-anda.com

OPENROUTER_API_KEY=...   # wajib diisi, dipakai fitur Kalkulator Politik & AI Article Generator
```

> ⚠️ **`APP_URL` harus persis sama** dengan protokol + domain yang benar-benar diakses (termasuk `https://`). Laravel dan Filament memakai nilai ini untuk membangun URL absolut ke asset (CSS/JS Filament, gambar via `Storage::url()`). Kalau salah/beda domain, browser akan diam-diam menolak me-load resource tersebut (mixed content / cross-origin) — biasanya **tidak** muncul sebagai 404 yang jelas di tab Network, jadi gampang bikin bingung. Gejalanya: halaman render normal tapi CSS-nya tidak jalan sama sekali.

### 4. Migrasi & seed database

```bash
php artisan migrate --force
```

### 5. Build asset frontend

```bash
npm run build
```

### 6. Publish asset Filament

```bash
php artisan filament:assets
```

Ini **wajib** dijalankan setiap kali install pertama kali atau setelah `composer update` yang menyentuh Filament — kalau terlewat, CSS/JS bawaan Filament (form, tabel, dsb di admin panel) tidak akan ter-load meskipun `npm run build` sudah dijalankan.

### 7. Symlink storage

```bash
php artisan storage:link
```

### 8. Set permission

```bash
sudo chown -R www-data:www-data /var/www/atomvisi.com
sudo chmod -R 775 storage bootstrap/cache
```

Sesuaikan `www-data` dengan user yang sebenarnya menjalankan PHP-FPM di server Anda (cek dengan `ps aux | grep php-fpm`).

### 9. Konfigurasi akses admin panel

Model `App\Models\User` harus meng-implementasikan `Filament\Models\Contracts\FilamentUser` dengan method `canAccessPanel()`. Ini **sudah** diimplementasikan di project ini (lihat `app/Models/User.php`), tapi penting untuk dipahami:

> ⚠️ Filament secara default **menolak akses (403) di semua environment kecuali `local`** kalau `User` tidak meng-implementasikan `canAccessPanel()`. Ini pengaman bawaan, bukan bug — supaya panel admin tidak sengaja terbuka lebar begitu production. Kalau suatu saat method ini dihapus/berubah dan tiba-tiba semua halaman admin jadi 403 setelah login (tapi normal di lokal), ini penyebabnya.

### 10. Konfigurasi Nginx

Contoh server block:

```nginx
server {
    server_name domain-anda.com;
    root /var/www/atomvisi.com/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan HTTPS dengan Certbot:

```bash
sudo certbot --nginx -d domain-anda.com
```

### 11. Cache untuk production (opsional, terakhir setelah semua di atas beres)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> Kalau nanti ubah `.env` lagi, wajib `php artisan config:clear` dulu (atau `config:cache` ulang) — perubahan `.env` tidak akan kepakai selama config masih ter-cache dari sebelumnya.

---

## Tutorial Setup Scheduler (Cron)

Fitur **AI Article Generator** (generate artikel otomatis terjadwal) butuh Laravel scheduler berjalan tiap menit di server. Tanpa ini, jadwal jam yang diatur di halaman **Pengaturan AI Artikel** tidak akan pernah jalan sendiri — cuma bisa jalan manual lewat tombol "Jalankan Sekarang".

### 1. Cek path PHP

```bash
which php8.3
```

### 2. Pasang cron untuk user yang sama dengan web server

Cek dulu user PHP-FPM:

```bash
ps aux | grep php-fpm
```

Biasanya `www-data`. Pasang crontab untuk user itu (bukan user pribadi Anda), supaya kepemilikan file yang ditulis scheduler (log, cache, session) konsisten dengan yang dipakai aplikasi sehari-hari:

```bash
sudo crontab -u www-data -e
```

Tambahkan baris (sesuaikan path project):

```
* * * * * cd /var/www/atomvisi.com && php8.3 artisan schedule:run >> /dev/null 2>&1
```

Simpan, lalu verifikasi:

```bash
sudo crontab -u www-data -l
```

### 3. Test manual sebelum menunggu jadwal asli

```bash
cd /var/www/atomvisi.com
sudo -u www-data php8.3 artisan articles:generate-ai --force
```

Kalau berhasil generate 1 artikel published, alurnya sudah benar.

### 4. Verifikasi cron benar-benar jalan tiap menit

```bash
sudo grep CRON /var/log/syslog | tail -20
```

Harus muncul baris baru tiap menit yang menyebut `schedule:run`.

### Catatan timezone

Jam yang diisi di halaman **Pengaturan AI Artikel** (misal `11:00`) selalu diinterpretasikan sebagai **WIB (Asia/Jakarta)**, terlepas dari timezone server atau `config('app.timezone')` (yang di-set `UTC`). Logic ini ada di `App\Models\AiArticleSetting::isDue()`. Jadi tidak perlu menyesuaikan timezone server — cron cukup jalan tiap menit seperti biasa, `isDue()` yang menentukan kapan waktunya benar-benar generate.

### Untuk development lokal

Tidak perlu crontab. Cukup jalankan di terminal terpisah:

```bash
php artisan schedule:work
```

Ini mensimulasikan cron (cek tiap menit) selama terminal itu dibiarkan terbuka. Tutup terminal = scheduler berhenti — jadi ini hanya untuk testing, bukan untuk production.

---

## Masalah Umum & Solusinya

| Gejala | Penyebab | Solusi |
|---|---|---|
| Halaman login/admin polos, CSS tidak muncul | `APP_URL` di `.env` tidak cocok dengan domain asli, atau `filament:assets` belum dijalankan | Betulkan `APP_URL`, jalankan `php artisan filament:assets`, lalu `php artisan config:clear` |
| Semua halaman admin panel 403 setelah login (tapi normal di lokal) | `User` model belum implement `canAccessPanel()` — default Filament menolak akses di luar `APP_ENV=local` | Pastikan `App\Models\User implements FilamentUser` dengan `canAccessPanel()` |
| Artikel AI tidak ada gambar cover | Model gambar OpenRouter yang dipakai sudah tidak tersedia, atau `OPENROUTER_API_KEY` belum diisi | Cek `storage/logs/laravel.log`, pastikan `OPENROUTER_API_KEY` terisi dan model di `OPENROUTER_IMAGE_MODEL` masih valid |
| Jadwal generate artikel otomatis tidak pernah jalan | Belum ada cron `schedule:run` di server, atau cron dipasang untuk user yang beda dari web server | Ikuti [Tutorial Setup Scheduler](#tutorial-setup-scheduler-cron) di atas |
| Gambar upload manual (tim, layanan, dll) tidak muncul di halaman publik | File tersimpan di disk yang salah | Semua field upload di Filament sudah eksplisit pakai `->disk('public')`, pastikan `php artisan storage:link` sudah dijalankan |
