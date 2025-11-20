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
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('users_id')->nullable();
            $table->string('nama_lengkap');
            $table->string('status_hubungan');
            $table->string('telepon');
            $table->string('alamat');
            $table->string('email')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
