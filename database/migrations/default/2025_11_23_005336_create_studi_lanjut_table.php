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
        Schema::create('studi_lanjut', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('users_id');
            $table->string('jenjang'); // S2, S3
            $table->string('program_studi');
            $table->string('universitas');
            $table->string('negara')->default('Indonesia');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('status'); // Sedang Berjalan, Selesai, Cuti
            $table->string('sumber_dana')->nullable(); // Beasiswa, Mandiri, dll
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studi_lanjut');
    }
};
