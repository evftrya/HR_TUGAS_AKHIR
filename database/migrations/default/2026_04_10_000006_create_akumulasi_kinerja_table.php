<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel AKUMULASI_KINERJA sesuai ERD.
     * Tabel ini menyimpan rekap/akumulasi kinerja per unit per bulan,
     * termasuk total menit kerja dan persentase capaian terhadap target.
     *
     * Tabel ini dihitung dari data PELAPORAN_KINERJA yang sudah disetujui.
     */
    public function up(): void
    {
        Schema::create('akumulasi_kinerja', function (Blueprint $table) {
            $table->id();
            // FK ke unit yang diakumulasi kinerjanya
            $table->unsignedBigInteger('unit_id');
            // Bulan (1-12)
            $table->tinyInteger('bulan')->unsigned();
            // Tahun
            $table->year('tahun');
            // Total menit kerja yang ter-approve dalam bulan/tahun ini
            $table->integer('total_menit')->default(0);
            // Persentase capaian terhadap target kontrak unit
            $table->decimal('persentase_capaian', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            // Satu unit hanya punya satu record akumulasi per bulan per tahun
            $table->unique(['unit_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akumulasi_kinerja');
    }
};
