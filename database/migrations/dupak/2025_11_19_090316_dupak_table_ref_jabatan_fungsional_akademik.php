<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The database connection that should be used by the migration.
     */
    protected $connection = 'dupak';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('ref_jabatan_fungsional_akademik', function (Blueprint $table) {
            
            // Primary Key
            $table->unsignedTinyInteger('id')->primary(); // tinyint UNSIGNED sesuai dengan SQL Anda

            // Nama Jabatan
            $table->string('nama', 20)->comment('Singkatan Jabatan Fungsional (e.g., AA, L, LK, GB)');
            $table->string('nama_panjang', 50)->comment('Nama lengkap Jabatan Fungsional (e.g., Asisten Ahli, Lektor Kepala)');

            // Angka Kredit Minimal (kum)
            $table->unsignedSmallInteger('kum')->comment('Angka Kredit minimal yang dibutuhkan untuk jabatan ini');
            
            // Timestamps
            $table->timestamps();
        });

        // --- Seeding Data Awal ---
        // Memasukkan data referensi JFA yang Anda berikan.
        DB::connection($this->connection)->table('ref_jabatan_fungsional_akademik')->insert([
            // ID 1: Non JAD (Bukan Jabatan Akademik Dosen) atau Calon Dosen/Pengajar
            ['id' => 1, 'nama' => 'NJAD', 'nama_panjang' => 'Non JAD', 'kum' => 0, 'created_at' => now(), 'updated_at' => now()],
            
            // ID 2: Asisten Ahli (AA)
            ['id' => 2, 'nama' => 'AA', 'nama_panjang' => 'Asisten Ahli', 'kum' => 150, 'created_at' => now(), 'updated_at' => now()],
            
            // ID 3: Lektor (L)
            ['id' => 3, 'nama' => 'L', 'nama_panjang' => 'Lektor', 'kum' => 200, 'created_at' => now(), 'updated_at' => now()],
            
            // ID 4: Lektor Kepala (LK)
            ['id' => 4, 'nama' => 'LK', 'nama_panjang' => 'Lektor Kepala', 'kum' => 450, 'created_at' => now(), 'updated_at' => now()],
            
            // ID 5: Guru Besar (GB)
            ['id' => 5, 'nama' => 'GB', 'nama_panjang' => 'Guru Besar', 'kum' => 850, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // Atur ulang AUTO_INCREMENT
        // DB::connection($this->connection)->statement('ALTER TABLE ref_jabatan_fungsional_akademik AUTO_INCREMENT = 6;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('ref_jabatan_fungsional_akademik');
    }
};