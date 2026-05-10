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
        Schema::create('induk_target_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_kinerja_harian_id')->constrained('target_kinerja_harian')->cascadeOnDelete();
            $table->foreignId('target_kinerja_id')->constrained('target_kinerja')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('induk_target_kinerja');
    }
};
