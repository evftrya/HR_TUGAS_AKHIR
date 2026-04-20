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
        Schema::create('ref_pangkat_golongans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pangkat');
            $table->string('golongan');
            $table->string('urut', 20)->comment('Urutan Jabatan')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_pangkat_golongans');
    }
};
