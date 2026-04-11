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
        Schema::create('kelompok_keahlian', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Ditambahkan primary()
            $table->string('nama', 100);
            $table->string('kode', 20)->unique();
            $table->text('deskripsi')->nullable();
            $table->foreignUuid('fakultas_id')->nullable();
            $table->timestamps();
            
            $table->foreign('fakultas_id')->references('id')->on('work_positions')->onDelete('set null');
        });

        Schema::create('ref_sub_kelompok_keahlians', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Ditambahkan primary()
            $table->string('nama', 100);
            $table->string('kode', 20)->unique();
            $table->text('deskripsi')->nullable();
            $table->foreignUuid('kk_id')->nullable();
            $table->timestamps();

            $table->foreign('kk_id')->references('id')->on('kelompok_keahlian')->onDelete('set null');
        });

        Schema::create('dosen_has_kk', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Ditambahkan primary()
            $table->foreignUuid('dosen_id');
            $table->foreignUuid('sub_kk_id');
            $table->boolean('is_active')->default(1);

            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('sub_kk_id')->references('id')->on('ref_sub_kelompok_keahlians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Urutan drop harus dari yang paling dependen (tabel pivot/child dulu)
        Schema::dropIfExists('dosen_has_kk');
        Schema::dropIfExists('ref_sub_kelompok_keahlians');
        Schema::dropIfExists('kelompok_keahlian');
    }
};