<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel KONTRAK_UNIT sesuai ERD.
     * Tabel junction antara KONTRAK_MANAJEMEN (target_kinerja) dan UNITS.
     * Menyimpan distribusi KPI ke masing-masing unit beserta target angkanya.
     */
    public function up(): void
    {
        Schema::create('kontrak_unit', function (Blueprint $table) {
            $table->id();
            // km_id = kontrak manajemen id (FK -> target_kinerja)
            $table->unsignedBigInteger('km_id');
            // unit_id = FK -> units
            $table->unsignedBigInteger('unit_id');
            // target kuantitatif yang harus dicapai unit ini
            $table->integer('target_angka')->default(0);
            $table->timestamps();

            $table->foreign('km_id')->references('id')->on('target_kinerja')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            // Satu KPI hanya bisa didistribusikan sekali ke satu unit
            $table->unique(['km_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontrak_unit');
    }
};
