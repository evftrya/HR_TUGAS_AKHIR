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
        Schema::create('prodis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fakultas_id')->nullable();
            $table->string('nama_prodi', 100);
            $table->string('kode', 100);
            $table->foreign('fakultas_id')->references('id')->on('faculties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};
