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
            $table->string('nama_jabatan');
            $table->string('minimal');
            $table->string('maximal');
            $table->timestamps();
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
