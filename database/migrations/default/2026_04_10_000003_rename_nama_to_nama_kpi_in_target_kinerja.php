<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyesuaikan kolom target_kinerja dengan ERD KONTRAK_MANAJEMEN:
     * - Rename nama -> nama_kpi
     * - Ubah tipe bobot menjadi decimal (sesuai ERD)
     * - Tambah kolom tahun (year type) sesuai ERD
     */
    public function up(): void
    {
        Schema::table('target_kinerja', function (Blueprint $table) {
            // Rename nama -> nama_kpi sesuai ERD
            $table->renameColumn('nama', 'nama_kpi');
        });

        Schema::table('target_kinerja', function (Blueprint $table) {
            // Ubah tipe bobot dari int ke decimal sesuai ERD
            $table->decimal('bobot', 8, 2)->default(0)->change();
            // Tambah kolom tahun (year) sesuai ERD — kolom periode tetap ada untuk backward compat.
            $table->year('tahun')->nullable()->after('satuan');
        });
    }

    public function down(): void
    {
        Schema::table('target_kinerja', function (Blueprint $table) {
            $table->renameColumn('nama_kpi', 'nama');
        });

        Schema::table('target_kinerja', function (Blueprint $table) {
            $table->integer('bobot')->default(0)->change();
            $table->dropColumn('tahun');
        });
    }
};
