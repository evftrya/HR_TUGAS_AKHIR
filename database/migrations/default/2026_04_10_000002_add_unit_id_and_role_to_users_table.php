<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom unit_id (FK ke units) dan role (enum)
     * ke tabel users sesuai ERD USERS.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah unit_id sebagai FK ke tabel units (nullable agar tidak break data lama)
            $table->unsignedBigInteger('unit_id')->nullable()->after('is_admin');
            // Tambah role enum sesuai ERD (admin, atasan, pegawai)
            // nullable agar data lama tidak error
            $table->enum('role', ['admin', 'atasan', 'pegawai'])->nullable()->after('unit_id');

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id', 'role']);
        });
    }
};
