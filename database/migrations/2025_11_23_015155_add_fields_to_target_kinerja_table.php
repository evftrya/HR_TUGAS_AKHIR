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
        Schema::table('target_kinerja', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->text('keterangan')->nullable()->after('nama');
            $table->integer('bobot')->default(0)->after('keterangan');
            $table->boolean('is_active')->default(true)->after('bobot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_kinerja', function (Blueprint $table) {
            $table->dropColumn(['nama', 'keterangan', 'bobot', 'is_active']);
        });
    }
};
