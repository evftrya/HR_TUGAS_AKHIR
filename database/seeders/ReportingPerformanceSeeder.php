<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporanPekerjaan;
use App\Models\TargetKinerjaHarian;
use App\Models\User;
use Carbon\Carbon;

class ReportingPerformanceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user yang bukan admin
        $users = User::where('is_admin', 0)->get();
        
        // Ambil beberapa target harian yang aktif
        $targets = TargetKinerjaHarian::where('is_active', 1)->get();

        if ($users->isEmpty() || $targets->isEmpty()) {
            $this->command->warn("Users atau Target Kinerja Harian kosong. Pastikan menjalankan UserSeeder dan TargetKinerjaHarianSeeder terlebih dahulu.");
            return;
        }

        $this->command->info("Memulai seeding data pelaporan untuk " . $users->count() . " user...");

        // Loop untuk 60 hari ke belakang agar ada data Bulanan & Tahunan
        for ($i = 0; $i < 60; $i++) {
            $date = Carbon::now()->subDays($i);
            
            // Jangan seeding di hari Sabtu/Minggu (opsional, biar realistis)
            if ($date->isWeekend()) continue;

            foreach ($users as $user) {
                // Setiap user melaporkan 1-3 pekerjaan per hari secara acak
                $numReports = rand(1, 3);
                
                for ($j = 0; $j < $numReports; $j++) {
                    $target = $targets->random();
                    
                    // Generate waktu pengerjaan (60 - 120 menit)
                    $waktuPengerjaan = rand(60, 180);
                    
                    // Generate waktu validasi atasan (agar ada variasi efektivitas)
                    // Variasi: Kurang (<337), Optimal (337-450), Overload (>450)
                    // Karena 1 user bisa lapor berkali-kali, kita buat total per hari mendekati 450
                    $waktuValidasi = rand(intval($waktuPengerjaan * 0.7), intval($waktuPengerjaan * 1.2));

                    PelaporanPekerjaan::create([
                        'user_id'                 => $user->id,
                        'target_harian_id'        => $target->id,
                        'tanggal'                 => $date->toDateString(),
                        'deskripsi'               => "Melaksanakan " . $target->pekerjaan . " - Iterasi " . ($j+1),
                        'menit_kerja'             => $waktuPengerjaan,
                        'realisasi'               => 'Pekerjaan selesai 100%',
                        'status'                  => 'approved',
                        'waktu_pengerjaan'        => $waktuPengerjaan,
                        'waktu_validasi_atasan'   => $waktuValidasi,
                        'created_by'              => $user->id,
                        'approved_by'             => 1, // Diasumsikan ID 1 adalah atasan/admin
                        'realisasi_jumlah'        => 1,
                        'realisasi_waktu_minutes' => $waktuPengerjaan,
                        'approved_jumlah'         => 1,
                        'approved_waktu_minutes'  => $waktuValidasi,
                        'created_at'              => $date,
                        'updated_at'              => $date,
                    ]);
                }
            }
        }

        $this->command->info("Seeding Pelaporan Kinerja selesai.");
    }
}
