<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('targets', function (Blueprint $table) {
            $table->id('id_target');
            $table->unsignedBigInteger('id_klaster');
            $table->unsignedBigInteger('id_program');
            $table->unsignedBigInteger('id_indikator');
            $table->integer('periode');           // Tahun, contoh: 2025
            $table->integer('target_tahunan');    // Nilai target, contoh: 940
            $table->integer('status')->default(1);
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->timestamps();

            $table->foreign('id_klaster')->references('id_klaster')->on('klasters')->onDelete('cascade');
            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('cascade');
            $table->foreign('id_indikator')->references('id_indikator')->on('indikators')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('targets');
    }
};
