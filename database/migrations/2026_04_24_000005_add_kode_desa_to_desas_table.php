<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('desas', function (Blueprint $table) {
            if (!Schema::hasColumn('desas', 'kode_desa')) {
                $table->string('kode_desa')->nullable()->after('id_desa')->unique();
            }
        });
    }

    public function down(): void {
        Schema::table('desas', function (Blueprint $table) {
            if (Schema::hasColumn('desas', 'kode_desa')) {
                $table->dropColumn('kode_desa');
            }
        });
    }
};
