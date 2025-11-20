<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FullDatabaseRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:full-refresh {--seed : Run the database seeder after refreshing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah khusus untuk menjalankan migrate:fresh pada koneksi default dan koneksi dupak secara berurutan.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai Proses Refresh Penuh Database...');

        // 1. Membersihkan dan memigrasikan database SEKUNDER (dupak)
        $this->comment('Membersihkan dan memigrasikan koneksi: dupak');
        // Kita hanya menjalankan migrate:fresh DENGAN SPESIFIK --database=dupak
        // Agar hanya migrasi koneksi 'dupak' yang diperhatikan pada database 'dupak'
        Artisan::call('migrate:fresh', [
            '--database' => 'dupak',
            '--path' => 'database/migrations/dupak', // Menjamin path folder migrasi tetap sama
            '--force' => true // Memaksa migrasi berjalan di production (walaupun ini dev)
        ], $this->output);

        // 2. Membersihkan dan memigrasikan database UTAMA (default)
        $this->comment('Membersihkan dan memigrasikan koneksi: default');
        // Tanpa argumen --database, ini menargetkan koneksi default
        Artisan::call('migrate:fresh', [
            '--path' => 'database/migrations/default',
            '--force' => true
        ], $this->output);

        // 3. Menjalankan Seeder (jika flag --seed diberikan)
        if ($this->option('seed')) {
            $this->comment('Menjalankan Seeder Database...');
            Artisan::call('db:seed', [
                '--force' => true
            ], $this->output);
        }

        $this->info('Proses Refresh Database Penuh Selesai!');

        return self::SUCCESS;
    }
}