<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('indikators', function (Blueprint $table) {
            // Tambah kolom id_klaster (relasi ke tabel klasters)
            if (!Schema::hasColumn('indikators', 'id_klaster')) {
                $table->unsignedBigInteger('id_klaster')->nullable()->after('id_indikator');
            }
        });
    }

    public function down(): void {
        Schema::table('indikators', function (Blueprint $table) {
            if (Schema::hasColumn('indikators', 'id_klaster')) {
                $table->dropColumn('id_klaster');
            }
        });
    }
};
