<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyesuaikan tabel pelaporan_pekerjaan dengan ERD PELAPORAN_KINERJA.
     * Kolom yang ditambahkan:
     *  - ku_id      : FK ke kontrak_unit (sesuai ERD: ku_id FK -> KONTRAK_UNIT)
     *  - user_id    : FK eksplisit ke users (alias created_by, konsisten dengan ERD user_id)
     *  - tanggal    : date — tanggal pelaporan
     *  - deskripsi  : text — deskripsi pekerjaan (sesuai ERD)
     *  - menit_kerja: int  — total menit kerja (sesuai ERD: menit_kerja int)
     *  - catatan_atasan: text — catatan dari atasan (sesuai ERD)
     *  - atasan_id  : FK ke users (sesuai ERD: atasan_id FK)
     *
     * Kolom lama (realisasi_waktu_minutes, realisasi_jumlah, dll) tetap ada
     * untuk menjaga backward compatibility dengan fitur yang sudah berjalan.
     */
    public function up(): void
    {
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            // Tambah FK ke kontrak_unit (nullable karena data lama tidak punya referensi ini)
            $table->unsignedBigInteger('ku_id')->nullable()->after('id');
            // user_id eksplisit (ERD menyebut user_id, proyek lama pakai created_by)
            // users.id adalah UUID (char 36), bukan bigint
            $table->uuid('user_id')->nullable()->after('ku_id');
            // Tanggal pelaporan
            $table->date('tanggal')->nullable()->after('user_id');
            // Deskripsi pekerjaan yang dilaporkan
            $table->text('deskripsi')->nullable()->after('tanggal');
            // Total menit kerja (ringkasan, ERD menyebutnya menit_kerja)
            $table->integer('menit_kerja')->nullable()->after('deskripsi');
            // Catatan dari atasan saat approval
            $table->text('catatan_atasan')->nullable()->after('status');
            // atasan_id — UUID juga karena users.id adalah UUID
            $table->uuid('atasan_id')->nullable()->after('catatan_atasan');

            $table->foreign('ku_id')->references('id')->on('kontrak_unit')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('atasan_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            $table->dropForeign(['ku_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['atasan_id']);
            $table->dropColumn(['ku_id', 'user_id', 'tanggal', 'deskripsi', 'menit_kerja', 'catatan_atasan', 'atasan_id']);
        });
    }
};
