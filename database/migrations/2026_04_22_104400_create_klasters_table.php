<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasters', function (Blueprint $table) {
            $table->id('id_klaster'); // Ini Primary Key-nya
            $table->string('nama_klaster');
            $table->boolean('status')->default(1); // 1 untuk aktif, 0 non-aktif
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->timestamps(); // Ini otomatis bikin created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klasters');
    }
};