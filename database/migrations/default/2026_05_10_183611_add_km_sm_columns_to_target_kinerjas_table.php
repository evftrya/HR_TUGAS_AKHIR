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
            $table->unsignedBigInteger('responsibility_id')->nullable();
            $table->enum('jenis', ['Kontrak Manajemen', 'Sasaran Mutu'])->nullable();
            $table->decimal('tw1_target', 8, 2)->default(0);
            $table->decimal('tw1_bobot', 8, 2)->default(0);
            $table->decimal('tw2_target', 8, 2)->default(0);
            $table->decimal('tw2_bobot', 8, 2)->default(0);
            $table->decimal('tw3_target', 8, 2)->default(0);
            $table->decimal('tw3_bobot', 8, 2)->default(0);
            $table->decimal('tw4_target', 8, 2)->default(0);
            $table->decimal('tw4_bobot', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_kinerja', function (Blueprint $table) {
            $table->dropColumn([
                'responsibility_id',
                'jenis',
                'tw1_target',
                'tw1_bobot',
                'tw2_target',
                'tw2_bobot',
                'tw3_target',
                'tw3_bobot',
                'tw4_target',
                'tw4_bobot',
            ]);
        });
    }
};
