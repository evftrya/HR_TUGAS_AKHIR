<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dosen_has_coe', function (Blueprint $table) {
            $table->uuid('dosen_id');
            $table->uuid('coe_id');
            $table->timestamps();

            $table->primary(['dosen_id', 'coe_id']);

            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->foreign('coe_id')->references('id')->on('coe')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_has_coe');
    }
};
