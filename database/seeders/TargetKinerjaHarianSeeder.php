<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetKinerjaHarian;
use App\Models\TargetKinerja;
use App\Models\User;
use Carbon\Carbon;

class TargetKinerjaHarianSeeder extends Seeder
{
    public function run()
    {
        // Ambil User ID pertama
        $user = User::first();
        
        // Ambil TargetKinerja ID pertama (ID 1)
        $targetKinerja = TargetKinerja::first();

        if ($user && $targetKinerja) {
            $harian = TargetKinerjaHarian::create([
                'user_id'           => $user->id,
                'pekerjaan'         => 'Penyusunan Laporan Penelitian Mingguan',
                'kontrak_type'      => 'pribadi',
                'target_kinerja_id' => $targetKinerja->id,
                'result'            => 'Laporan Kemajuan',
                'satuan'            => 'menit',
                'target'            => 100,
                'bobot'             => 2,
                'jumlah'            => 1,
                'waktu_minutes'     => 90,
                'is_active'         => 1,
                'start'             => Carbon::now()->startOfDay()->toDateTimeString(),
                'end'               => Carbon::now()->endOfDay()->toDateTimeString(),
            ]);

            // Hubungkan ke Induk KPI menggunakan pivot sync
            $harian->indukKpi()->sync([$targetKinerja->id]);
        }
    }
}
