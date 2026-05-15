#!/bin/bash

echo "🚀 Memulai setup otomatis Laravel di Replit..."

# 1. Copy .env dari awal (fresh copy)
echo "📄 Menyalin .env.example ke .env..."
cp .env.example .env

# 2. Update .env agar menggunakan SQLite dengan path absolut
echo "⚙️  Mengatur database ke SQLite..."
SQLITE_PATH="$(pwd)/database/database.sqlite"
sed -i "s|DB_CONNECTION=mysql|DB_CONNECTION=sqlite|g" .env
sed -i "s|DB_CONNECTION=sqlite|DB_CONNECTION=sqlite\nDB_DATABASE=${SQLITE_PATH}|g" .env
sed -i '/^DB_HOST=/d' .env
sed -i '/^DB_PORT=/d' .env
sed -i '/^DB_DATABASE=laravel/d' .env
sed -i '/^# DB_HOST=/d' .env
sed -i '/^# DB_PORT=/d' .env
sed -i '/^# DB_DATABASE=/d' .env
sed -i '/^# DB_USERNAME=/d' .env
sed -i '/^# DB_PASSWORD=/d' .env
sed -i '/^DB_USERNAME=/d' .env
sed -i '/^DB_PASSWORD=/d' .env

# 3. Buat file database sqlite
echo "📁 Membuat file database.sqlite..."
touch database/database.sqlite

# 4. Install dependensi
echo "📦 Menginstal dependensi (Composer)..."
composer install --no-interaction --prefer-dist

# 5. Clear cache
php artisan config:clear
php artisan cache:clear

# 6. Generate Key
echo "🔑 Membuat Application Key..."
php artisan key:generate

# 7. Migrasi Database
echo "🗄️  Menjalankan Migrasi & Seeder..."
php artisan migrate:fresh --seed

echo "✅ SETUP SELESAI! Silakan klik tombol RUN di atas."
