<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tables = ['users', 'klasters', 'desas', 'programs', 'indikators', 'capaians'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Tambah Status (Default 1 = Aktif), ditaruh otomatis di belakang
                if (!Schema::hasColumn($tableName, 'status')) {
                    $table->integer('status')->default(1); 
                }
                // Tambah Create By & Update By
                if (!Schema::hasColumn($tableName, 'create_by')) {
                    $table->string('create_by')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'update_by')) {
                    $table->string('update_by')->nullable();
                }
            });
        }
    }

    public function down(): void {
        // Biarkan kosong dulu
    }
};