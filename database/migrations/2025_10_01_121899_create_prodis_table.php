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
            $table->uuid('prodi_id')->nullable();
            $table->uuid('fakultas_id')->nullable();
            
            $table->foreign('fakultas_id')->references('id')->on('work_positions')->onDelete('set null');
            $table->foreign('prodi_id')->references('id')->on('work_positions')->onDelete('set null');
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
