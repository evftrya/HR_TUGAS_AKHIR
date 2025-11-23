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
            $table->uuid('id')->primary();
            $table->string('nama_kk');
            $table->string('sub_kk')->nullable();
            $table->timestamps();
        });

        // Pivot table untuk relasi many-to-many dosen dan kelompok keahlian
        Schema::create('dosen_has_kk', function (Blueprint $table) {
            $table->uuid('dosen_id');
            $table->uuid('kk_id');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('kk_id')->references('id')->on('kelompok_keahlian')->onDelete('cascade');
            $table->primary(['dosen_id', 'kk_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_has_kk');
        Schema::dropIfExists('kelompok_keahlian');
    }
};
