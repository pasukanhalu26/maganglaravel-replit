<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel utama penyimpanan nomor
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            // String untuk menjaga angka 0 di depan. Index mutlak wajib untuk web pencarian!
            $table->string('phone_number', 20)->unique()->index(); 
            // Fitur privasi: True = Sembunyikan dari publik
            $table->boolean('is_hidden')->default(false); 
            $table->timestamps();
        });

        // Tabel relasi untuk daftar nama/tag kontak
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('number_id')->constrained('numbers')->onDelete('cascade');
            $table->string('name', 100); // Nama yang disimpan/ditag oleh orang
            $table->timestamps();
            
            // Index pada Foreign Key mempercepat Eloquent Eager Loading
            $table->index('number_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('numbers');
    }
};
