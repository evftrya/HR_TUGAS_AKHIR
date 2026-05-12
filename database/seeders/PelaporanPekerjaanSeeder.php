<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporanPekerjaan;
use App\Models\TargetKinerjaHarian;
use App\Models\User;

class PelaporanPekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $harian = TargetKinerjaHarian::first();
        $user = User::first();

        if ($harian && $user) {
            PelaporanPekerjaan::create([
                'user_id'                 => $user->id,
                'target_harian_id'        => $harian->id,
                'tanggal'                 => now()->toDateString(),
                'deskripsi'               => 'Mengerjakan laporan penelitian bab 1 dan 2',
                'menit_kerja'             => 120,
                'realisasi'               => 'Selesai bab 1 dan 2',
                'status'                  => 'pending',
                'waktu_pengerjaan'        => 90,
                'waktu_validasi_atasan'   => 100,
                'created_by'              => $user->id,
                'realisasi_jumlah'        => 1,
                'realisasi_waktu_minutes' => 120,
            ]);
        }
    }
}
