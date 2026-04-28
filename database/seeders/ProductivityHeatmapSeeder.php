<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporanPekerjaan;
use App\Models\User;
use App\Models\KontrakUnit;
use App\Models\TargetKinerjaHarian;
use Carbon\Carbon;

class ProductivityHeatmapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $kontrakUnit = KontrakUnit::first();
        $targetHarian = TargetKinerjaHarian::first();

        if ($users->isEmpty()) {
            $this->command->info('No users found, skipping ProductivityHeatmapSeeder');
            return;
        }

        $this->command->info('Seeding productivity heatmap data for ' . $users->count() . ' users...');

        foreach ($users as $user) {
            $data = [];
            // Generate entries for roughly 60% of the days in the last year
            for ($i = 0; $i < 365; $i++) {
                if (rand(1, 10) > 4) { // 60% chance to have an entry
                    $date = Carbon::now()->subDays($i);
                    
                    // Random work minutes to cover all color ranges:
                    // 0: #ebedf0, 1-120: light, 121-240: medium, 241-480: dark, >480: very dark
                    $ranges = [60, 180, 300, 600];
                    $minutes = $ranges[array_rand($ranges)];

                    $data[] = [
                        'user_id' => $user->id,
                        'ku_id' => $kontrakUnit?->id,
                        'target_harian_id' => $targetHarian?->id,
                        'tanggal' => $date->toDateString(),
                        'deskripsi' => 'Kegiatan rutin pada ' . $date->format('d M Y'),
                        'menit_kerja' => $minutes,
                        'realisasi_waktu_minutes' => $minutes,
                        'approved_waktu_minutes' => $minutes,
                        'status' => 'approved',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }

                // Batch insert every 50 records to be efficient
                if (count($data) >= 50) {
                    PelaporanPekerjaan::insert($data);
                    $data = [];
                }
            }
            
            if (count($data) > 0) {
                PelaporanPekerjaan::insert($data);
            }
        }

        $this->command->info('ProductivityHeatmapSeeder completed!');
    }
}
