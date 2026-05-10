<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            $table->integer('waktu_validasi_atasan')->nullable()->comment('Waktu validasi atasan dalam satuan menit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            $table->dropColumn('waktu_validasi_atasan');
        });
    }
};
