<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('id_program');
            // Baris di bawah ini fungsinya untuk menghubungkan ke tabel klaster
            $table->foreignId('id_klaster')->constrained('klasters', 'id_klaster')->onDelete('cascade');
            $table->string('nama_program');
            $table->boolean('status')->default(1);
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};