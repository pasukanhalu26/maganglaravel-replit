<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('capaians', function (Blueprint $table) {
            $table->text('analisa_masalah')->nullable()->after('capaian_bulan');
            $table->text('rtl')->nullable()->after('analisa_masalah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('capaians', function (Blueprint $table) {
            $table->dropColumn(['analisa_masalah', 'rtl']);
        });
    }
};
