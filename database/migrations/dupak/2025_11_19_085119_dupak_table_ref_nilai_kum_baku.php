<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The database connection that should be used by the migration.
     */
    protected $connection = 'dupak';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('ref_nilai_kum_baku', function (Blueprint $table) {
            
            // Primary Key (sesuai data Anda)
            $table->unsignedSmallInteger('id')->primary();

            // Data Kriteria
            $table->string('nama', 100)->comment('Nama kriteria nilai baku (e.g., Penulis Pertama, Mata Kuliah Dasar)');

            // Foreign Key ke ref_kegiatan_komponen
            // Menggunakan int sesuai schema SQL Anda, tetapi sebaiknya unsignedBigInteger untuk konsistensi
            $table->unsignedBigInteger('idKegiatanKomponen')->comment('Foreign key ke ref_kegiatan_komponen');
            
            // Nilai Angka Kredit Baku
            // Menggunakan decimal(5, 3) untuk akurasi nilai AK, bukan int.
            // Nilai '1' dan '0' dari data Anda akan menjadi 1.000 dan 0.000.
            $table->decimal('nilai_kum_baku', 5, 3)->comment('Nilai Angka Kredit baku (sebelum dikalikan faktor)');
            
            // Timestamps (Opsional, tapi disarankan untuk tracking)
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('idKegiatanKomponen')->references('id')->on('ref_kegiatan_komponen')->onDelete('cascade');
        });

        // --- Seeding Data Awal ---
        // Memasukkan data referensi yang Anda berikan. Kolom 'value' diubah menjadi 'nilai_kum_baku'.
        DB::connection($this->connection)->table('ref_nilai_kum_baku')->insert([
            // ID 111 dan 112 (Mengacu ke komponen ID 11 - Menyampaikan Orasi Ilmiah)
            ['id' => 111, 'nama' => 'Penulis Pertama', 'idKegiatanKomponen' => 11, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 112, 'nama' => 'Penulis Kedua/Anggota', 'idKegiatanKomponen' => 11, 'nilai_kum_baku' => 0.000, 'created_at' => now(), 'updated_at' => now()],
            
            // ID 131 dan 132 (Mengacu ke komponen ID 13 - Membimbing dosen yang lebih rendah)
            // Catatan: Anda menggunakan ID 13 di sini, tetapi berdasarkan data DUPAK standar,
            // 13 adalah "Membimbing dosen yang lebih rendah" (Komponen II. K), yang nilainya 1.
            ['id' => 131, 'nama' => 'Mata Kuliah Dasar (SKS)', 'idKegiatanKomponen' => 13, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 132, 'nama' => 'Mata Kuliah Lanjut (SKS)', 'idKegiatanKomponen' => 13, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],
            
            // ID 141 dan 142 (Mengacu ke komponen ID 14 - Melaksanakan kegiatan datasering dan pencangkokan)
            // Catatan: Anda menggunakan ID 14 di sini, yang nilainya juga 1.
            ['id' => 141, 'nama' => 'Ketua Pembimbing (Mahasiswa)', 'idKegiatanKomponen' => 14, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 142, 'nama' => 'Anggota Pembimbing (Mahasiswa)', 'idKegiatanKomponen' => 14, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],

            // ID 601 dan 602 (Mengacu ke komponen ID 6 - Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi)
            ['id' => 601, 'nama' => 'Ketua Pembimbing', 'idKegiatanKomponen' => 6, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 602, 'nama' => 'Anggota Pembimbing', 'idKegiatanKomponen' => 6, 'nilai_kum_baku' => 1.000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('ref_nilai_kum_baku');
    }
};