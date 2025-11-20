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
        Schema::create('riwayat_nips', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip')->nullable();
            $table->foreignUuid('status_pegawai_id')->nullable();
            $table->foreignUuid('users_id')->nullable();
            $table->date('tmt_mulai');
            $table->date('tmt_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            // $table->string('no_sk')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('status_pegawai_id')->references('id')->on('ref_status_pegawais')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_pegawais');
    }
};
