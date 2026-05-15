<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indikators', function (Blueprint $table) {
            $table->id('id_indikator');
            // Menghubungkan ke tabel program
            $table->foreignId('id_program')->constrained('programs', 'id_program')->onDelete('cascade');
            $table->string('nama_indikator');
            $table->string('target'); // Contoh: 100
            $table->string('satuan'); // Contoh: %, Orang, Desa
            $table->boolean('status')->default(1);
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikators');
    }
};