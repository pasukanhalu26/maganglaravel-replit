<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('capaians');

        Schema::create('capaians', function (Blueprint $table) {
            $table->id('id_capaian');
            $table->unsignedBigInteger('id_target'); // Referensi langsung ke target
            $table->unsignedBigInteger('id_desa');
            $table->integer('bulan'); // 1-12
            $table->integer('capaian_bulan'); // Nilai capaian
            $table->integer('status')->default(1);
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->timestamps();

            // Relasi
            $table->foreign('id_target')->references('id_target')->on('targets')->onDelete('cascade');
            $table->foreign('id_desa')->references('id_desa')->on('desas')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('capaians');
    }
};