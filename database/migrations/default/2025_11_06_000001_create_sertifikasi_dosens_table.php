<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_registrasi', 50)->unique()->nullable();
            $table->string('biaya_pelatihan')->nullable();
            $table->string('judul',300)->nullable();
            $table->enum('tipe_sertifikasi', ['Pelatihan', 'Kompetensi'])->nullable();
            $table->enum('pelaksanaan', ['Online', 'Offline','Hybrid'])->nullable();
            $table->date('tgl_berlaku_sertifikasi', 100)->nullable();
            $table->date('tgl_pelaksana', 100)->nullable();
            $table->date('tgl_sertifikasi', 100)->nullable();
            $table->string('nama_file', 100)->nullable();
            $table->string('path', 100)->nullable();
            $table->timestamps();


            // $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikasis');
    }
};
