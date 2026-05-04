<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::take(5)->get();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();

        foreach ($users as $user) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                if ($date->isWeekend()) continue;

                // Random check-in time between 07:30 and 08:30
                $hour = rand(7, 8);
                $minute = ($hour == 7) ? rand(30, 59) : rand(0, 30);
                
                $jamMasuk = $date->copy()->setTime($hour, $minute, 0);
                $jamPulang = $date->copy()->setTime(17, rand(0, 30), 0);

                Presensi::create([
                    'user_id' => $user->id,
                    'tanggal' => $date->toDateString(),
                    'jam_masuk' => $jamMasuk->toTimeString(),
                    'jam_pulang' => $jamPulang->toTimeString(),
                    'status' => 'Hadir'
                ]);
            }
        }
    }
}
