#!/bin/sh

echo "=== MEMULAI STARTUP SCRIPT CUSTOM LARAVEL ==="

# 1. Salin konfigurasi Nginx kustom ke folder konfigurasi aktif
if [ -f "/home/site/wwwroot/azure/nginx.conf" ]; then
    echo "Menyalin konfigurasi Nginx kustom..."
    cp /home/site/wwwroot/azure/nginx.conf /etc/nginx/sites-available/default 2>/dev/null || true
    cp /home/site/wwwroot/azure/nginx.conf /etc/nginx/sites-enabled/default 2>/dev/null || true
    cp /home/site/wwwroot/azure/nginx.conf /etc/nginx/conf.d/default.conf 2>/dev/null || true
    
    echo "Reloading Nginx service..."
    nginx -s reload 2>/dev/null || service nginx reload 2>/dev/null || true
fi

# 2. Pindah ke direktori root aplikasi
cd /home/site/wwwroot 2>/dev/null || true

# 3. Hapus file placeholder Azure jika ada
rm -f /home/site/wwwroot/hostingstart.html 2>/dev/null || true

# 4. Pastikan folder & file SQLite persisten ada di /home/database jika menggunakan SQLite
if [ "$DB_CONNECTION" = "sqlite" ]; then
    echo "Memastikan folder dan file SQLite persisten di /home/database..."
    mkdir -p /home/database
    if [ ! -f "/home/database/database.sqlite" ]; then
        echo "Membuat file database SQLite baru di /home/database/database.sqlite..."
        touch /home/database/database.sqlite
    fi
fi

# 5. Jalankan migrasi database jika RUN_MIGRATIONS=true
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Menjalankan migrasi database..."
    php artisan migrate --force 2>/dev/null || true
fi

# 6. Bersihkan dan bangun cache Laravel
echo "Membangun cache konfigurasi dan rute Laravel..."
php artisan optimize:clear 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# 7. Konfigurasi symbolic link untuk storage
echo "Mengonfigurasi symbolic link untuk storage..."
rm -rf public/storage 2>/dev/null || true
php artisan storage:link 2>/dev/null || true

echo "=== STARTUP SCRIPT SELESAI ==="
