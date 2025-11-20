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
        Schema::create('formations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_formasi', 100);
            $table->foreignUuid('level_id')->nullable();
            $table->foreignUuid('atasan_formasi_id')->nullable();
            $table->foreignUuid('bagian')->nullable();
            $table->foreignUuid('prodi')->nullable();
            $table->foreignUuid('fakultas')->nullable();
            $table->integer('kuota')->nullable();
            $table->timestamps();
            
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            $table->foreign('atasan_formasi_id')->references('id')->on('formations')->onDelete('set null');
            $table->foreign('bagian')->references('id')->on('ref_bagians')->onDelete('set null');
            $table->foreign('prodi')->references('id')->on('prodis')->onDelete('set null');
            $table->foreign('fakultas')->references('id')->on('faculties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
