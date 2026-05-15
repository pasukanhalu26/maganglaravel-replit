<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('capaians', function (Blueprint $table) {
            $table->integer('capaian_kumulatif')->nullable()->after('capaian_bulan');
        });
    }

    public function down(): void
    {
        Schema::table('capaians', function (Blueprint $table) {
            $table->dropColumn('capaian_kumulatif');
        });
    }
};
