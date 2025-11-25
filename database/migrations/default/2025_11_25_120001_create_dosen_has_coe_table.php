<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create pivot table `dosen_has_coe` separately to keep migrations focused
        Schema::create('dosen_has_coe', function (Blueprint $table) {
            $table->foreignUuid('dosen_id')->constrained('dosens')->cascadeOnDelete();
            $table->foreignUuid('coe_id')->constrained('coe')->cascadeOnDelete();

            $table->primary(['dosen_id', 'coe_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_has_coe');
    }
};
