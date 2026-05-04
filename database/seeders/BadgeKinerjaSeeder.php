<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporanPekerjaan;
use App\Models\TargetKinerjaHarian;
use App\Models\User;
use Carbon\Carbon;

class BadgeKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil salah satu user (misal user pertama)
        $user = User::first();
        
        if (!$user) {
            $this->command->error('Tidak ada user ditemukan.');
            return;
        }

        // 2. Pastikan ada target harian
        $targetHarian = TargetKinerjaHarian::first();
        if (!$targetHarian) {
            $targetHarian = TargetKinerjaHarian::create([
                'pekerjaan' => 'Tugas Rutin untuk Badge',
                'waktu_minutes' => 120,
                'is_active' => 1
            ]);
        }

        $this->command->info("Membuat data untuk user: {$user->nama_lengkap}");

        // Hapus data lama user ini agar fresh
        PelaporanPekerjaan::where('user_id', $user->id)->delete();

        // 3. Buat 10 Laporan berturut-turut dengan status 'approved' ("The Reliable")
        // Dan waktu create_at sebelum jam 17:00 ("Speedy Submitter")
        
        $baseDate = Carbon::now()->subDays(10);

        for ($i = 0; $i < 10; $i++) {
            $reportDate = $baseDate->copy()->addDays($i);
            
            // Set waktu antara jam 08:00 sampai 16:00 untuk menjamin Speedy Submitter (< 17)
            $reportDate->setHour(rand(8, 16))->setMinute(rand(0, 59));

            PelaporanPekerjaan::create([
                'user_id' => $user->id,
                'target_harian_id' => $targetHarian->id,
                'status' => 'approved', // Menjamin "The Reliable"
                'realisasi' => 'Penyelesaian tugas harian ke-' . ($i + 1),
                'realisasi_waktu_minutes' => rand(60, 120),
                'approved_waktu_minutes' => rand(60, 120),
                'created_by' => $user->id,
                'approved_by' => 1,
                'created_at' => $reportDate,
                'updated_at' => $reportDate->copy()->addHours(1),
                'tanggal' => $reportDate->toDateString(),
            ]);
        }

        $this->command->info('Seeder Badge berhasil dijalankan! Silakan login dengan user tersebut untuk melihat kedua lencana.');
    }
}
