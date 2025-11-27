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
        Schema::create('ref_jabatan_fungsional_akademiks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->string('nama_jabatan');
            
            // $table->unsignedTinyInteger('id')->primary(); // tinyint UNSIGNED sesuai dengan SQL Anda
            
            // Nama Jabatan
            $table->string('kode', 20)->comment('Singkatan Jabatan Fungsional (e.g., AA, L, LK, GB)');
            $table->string('nama_jabatan', 50)->comment('Nama lengkap Jabatan Fungsional (e.g., Asisten Ahli, Lektor Kepala)');
            
            // Angka Kredit Minimal (kum)
            $table->unsignedSmallInteger('kum')->comment('Angka Kredit minimal yang dibutuhkan untuk jabatan ini');
            $table->timestamps();
            
            // Timestamps
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_jabatan_fungsional_akademiks');
    }
};
