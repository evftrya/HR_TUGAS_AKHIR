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
        Schema::connection($this->connection)->create('ref_kegiatan_utama', function (Blueprint $table) {
            
            $table->id(); // Auto-incrementing primary key (matches `id` int NOT NULL)

            // Original: `nama` varchar(100) NOT NULL
            $table->string('nama', 100)->comment('Nama kegiatan utama DUPAK (e.g., Pendidikan, Penelitian)');

            // Original: `status` int NOT NULL
            $table->unsignedTinyInteger('status')->default(1)->comment('Status aktif: 1=Aktif, 0=Tidak Aktif');
            
            // Standard Laravel timestamps
            $table->timestamps(); 
        });

        // --- Seeding Data Awal ---
        // Memasukkan data referensi kegiatan utama
        DB::connection($this->connection)->table('ref_kegiatan_utama')->insert([
            ['id' => 1, 'nama' => 'I. Pendidikan', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'II. Pelaksanaan Pendidikan', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'III. Pelaksanaan Penelitian', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'IV. Pelaksanaan Pengabdian Kepada Masyarakat', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama' => 'V. Penunjang Kegiatan Akademik Dosen', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('ref_kegiatan_utama');
    }
};