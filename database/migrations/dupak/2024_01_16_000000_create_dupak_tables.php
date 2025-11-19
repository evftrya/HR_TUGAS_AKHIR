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
        // Schema::connection('dupak')->create('kegiatan', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kategori');
        //     $table->string('sub_kategori')->nullable();
        //     $table->string('nama');
        //     $table->string('satuan_hasil');
        //     $table->decimal('angka_kredit', 8, 2);
        //     $table->timestamps();
        // });

        // Schema::connection('dupak')->create('pengajuan', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nip');  // This will reference the nip from sdm_tus.dosen table but without foreign key constraint
        //     $table->string('periode_id');
        //     $table->date('tanggal_pengajuan');
        //     $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        //     $table->text('catatan')->nullable();
        //     $table->decimal('total_angka_kredit', 8, 2)->default(0);
        //     $table->decimal('total_angka_kredit_disetujui', 8, 2)->nullable();
        //     $table->timestamps();
            
        //     // We don't create a foreign key constraint here since it's in a different database
        //     // We'll handle the relationship at the application level
        // });

        // Schema::connection('dupak')->create('pengajuan_detail', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
        //     $table->foreignId('kegiatan_id')->constrained('kegiatan');
        //     $table->string('bukti')->nullable();
        //     $table->decimal('angka_kredit', 8, 2);
        //     $table->decimal('angka_kredit_disetujui', 8, 2)->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dupak')->dropIfExists('pengajuan_detail');
        Schema::connection('dupak')->dropIfExists('pengajuan');
        Schema::connection('dupak')->dropIfExists('kegiatan');
    }
};