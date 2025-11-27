<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create `coe` table only (pivot moved to next migration)
        Schema::create('coe', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_coe')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_has_coe');
        Schema::dropIfExists('coe');
    }
};
