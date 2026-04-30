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
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            // Update approved_waktu_minutes to have default 0
            $table->integer('approved_waktu_minutes')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaporan_pekerjaan', function (Blueprint $table) {
            $table->integer('approved_waktu_minutes')->nullable()->default(null)->change();
        });
    }
};
