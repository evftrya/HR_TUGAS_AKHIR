<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporanPekerjaan;
use App\Models\TargetKinerjaHarian;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaderboardKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama untuk bulan ini jika ingin fresh (opsional)
        // PelaporanPekerjaan::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->delete();

        $users = User::take(10)->get();
        $targetHarian = TargetKinerjaHarian::first();

        if (!$targetHarian) {
            $targetHarian = TargetKinerjaHarian::create([
                'pekerjaan' => 'Pekerjaan Umum',
                'waktu_minutes' => 60,
                'is_active' => 1
            ]);
        }

        // Kita buat data untuk 5-10 user dengan total menit yang berbeda-beda
        // User 1: Juara 1 (misal 2000 menit)
        // User 2: Juara 2 (misal 1800 menit)
        // ... dst
        
        $minutesBase = [2000, 1800, 1500, 1200, 1000, 800, 500, 300, 100, 50];

        foreach ($users as $index => $user) {
            if (!isset($minutesBase[$index])) break;

            $totalTarget = $minutesBase[$index];
            $currentSum = 0;

            // Pecah total menit menjadi beberapa laporan
            while ($currentSum < $totalTarget) {
                $randomMinutes = rand(60, 240);
                if ($currentSum + $randomMinutes > $totalTarget) {
                    $randomMinutes = $totalTarget - $currentSum;
                }

                PelaporanPekerjaan::create([
                    'user_id' => $user->id,
                    'target_harian_id' => $targetHarian->id,
                    'status' => 'approved',
                    'realisasi' => 'Pengerjaan tugas harian rutin.',
                    'realisasi_waktu_minutes' => $randomMinutes,
                    'approved_waktu_minutes' => $randomMinutes,
                    'created_by' => $user->id,
                    'approved_by' => 1, // Anggap admin id 1
                    'created_at' => Carbon::now()->startOfMonth()->addDays(rand(0, now()->day - 1))->addHours(rand(8, 17)),
                    'tanggal' => now()->toDateString(),
                ]);

                $currentSum += $randomMinutes;
            }
        }

        $this->command->info('Seeder Leaderboard Kinerja berhasil dijalankan.');
    }
}
