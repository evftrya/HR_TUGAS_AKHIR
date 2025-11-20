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
        Schema::create('tpas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('users_id')->nullable();
            $table->string('nitk')->unique()->nullable();
            $table->string('bagian_id')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('bagian_id')->references('id')->on('ref_bagians')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpas');
    }
};
