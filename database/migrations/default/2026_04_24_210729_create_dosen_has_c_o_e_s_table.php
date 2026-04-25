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
        Schema::create('dosen_has_c_o_e_s', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('dosen_id')->constrained('dosens')->cascadeOnDelete();
            $table->foreignUuid('coe_id')->constrained('coe')->cascadeOnDelete();
            $table->date('tmt_mulai');
            $table->date('tmt_selesai')->nullable();

            $table->timestamps();
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('coe_id')->references('id')->on('coe')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_has_c_o_e_s');
    }
};
