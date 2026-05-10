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
        // TUGAS 2: Update Tabel target_kinerja
        Schema::table('target_kinerja', function (Blueprint $table) {
            if (Schema::hasColumn('target_kinerja', 'bobot')) {
                $table->dropColumn('bobot');
            }
            if (Schema::hasColumn('target_kinerja', 'target_percent')) {
                $table->dropColumn('target_percent');
            }
            $table->string('satuan')->nullable()->change();
        });

        // TUGAS 3: Update Tabel target_kinerja_harian
        Schema::table('target_kinerja_harian', function (Blueprint $table) {
            if (!Schema::hasColumn('target_kinerja_harian', 'satuan')) {
                $table->string('satuan')->nullable();
            }
            if (!Schema::hasColumn('target_kinerja_harian', 'target')) {
                $table->decimal('target', 8, 2)->default(0);
            }
            // bobot sudah ada, abaikan atau modifikasi jika perlu
            if (!Schema::hasColumn('target_kinerja_harian', 'waktu')) {
                $table->string('waktu')->nullable();
            }
        });

        // TUGAS 3: Update Tabel pelaporan_pekerjaan
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            if (!Schema::hasColumn('pelaporan_pekerjaan', 'waktu_pengerjaan')) {
                $table->integer('waktu_pengerjaan')->nullable()->comment('Inputan klaim menit dari pegawai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_kinerja', function (Blueprint $table) {
            $table->decimal('bobot', 8, 2)->default(0);
            $table->integer('target_percent')->nullable();
        });

        Schema::table('target_kinerja_harian', function (Blueprint $table) {
            $table->dropColumn(['satuan', 'target', 'bobot', 'waktu']);
        });

        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            $table->dropColumn('waktu_pengerjaan');
        });
    }
};
