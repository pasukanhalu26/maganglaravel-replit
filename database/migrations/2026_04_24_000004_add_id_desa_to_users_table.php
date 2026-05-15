<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_desa')) {
                $table->unsignedBigInteger('id_desa')->nullable()->after('role');
                $table->foreign('id_desa')->references('id_desa')->on('desas')->onDelete('set null');
            }
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'id_desa')) {
                $table->dropForeign(['id_desa']);
                $table->dropColumn('id_desa');
            }
        });
    }
};
