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
        Schema::create('testing_s_i_m_d_k_s', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->json('test_statuses')->nullable();
            $table->foreignUuid('users_id')->nullable();

            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testing_s_i_m_d_k_s');
    }
};
