#!/bin/bash

echo "🚀 Memulai setup otomatis Laravel di Replit..."

# 1. Copy .env jika belum ada
if [ ! -f .env ]; then
    echo "📄 Menyalin .env.example ke .env..."
    cp .env.example .env
fi

# 2. Update .env agar menggunakan SQLite
echo "⚙️  Mengatur database ke SQLite..."
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/g' .env
sed -i 's/DB_HOST=/#DB_HOST=/g' .env
sed -i 's/DB_PORT=/#DB_PORT=/g' .env
sed -i 's/DB_DATABASE=/#DB_DATABASE=/g' .env
sed -i 's/DB_USERNAME=/#DB_USERNAME=/g' .env
sed -i 's/DB_PASSWORD=/#DB_PASSWORD=/g' .env

# 3. Buat database sqlite jika belum ada
if [ ! -f database/database.sqlite ]; then
    echo "📁 Membuat file database.sqlite..."
    touch database/database.sqlite
fi

# 4. Install dependensi
echo "📦 Menginstal dependensi (Composer)..."
composer install --no-interaction --prefer-dist

# 5. Generate Key
echo "🔑 Membuat Application Key..."
php artisan key:generate

# 6. Migrasi Database
echo "🗄️  Menjalankan Migrasi & Seeder..."
php artisan migrate:fresh --seed

echo "✅ SETUP SELESAI! Silakan klik tombol RUN di atas."
