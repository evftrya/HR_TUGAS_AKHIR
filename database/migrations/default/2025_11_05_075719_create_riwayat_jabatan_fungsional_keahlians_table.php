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
        Schema::create('riwayat_jabatan_fungsional_keahlians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ref_jfk_id')->nullable();
            $table->foreignUuid('tpa_id')->nullable();
            $table->date('tmt_mulai');
            $table->date('tmt_selesai')->nullable();
            // $table->foreignUuid('sk_llkdikti_id')->nullable();
            $table->foreignUuid('sk_pengakuan_ypt_id')->nullable();
            
            $table->timestamps();
            
            // $table->foreign('sk_llkdikti_id')->references('id')->on('sks')->onDelete('set null');
            $table->foreign('sk_pengakuan_ypt_id')->references('id')->on('sks')->onDelete('set null');
            $table->foreign('tpa_id')->references('id')->on('tpas')->onDelete('set null');
            $table->foreign('ref_jfk_id')->references('id')->on('ref_jabatan_fungsional_keahlians')->onDelete('set null');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan_fungsional_keahlians');
    }
};
