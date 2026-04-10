<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PelaporanPekerjaan;
use App\Models\TargetKinerjaHarian;
use App\Models\KontrakUnit;
use App\Models\User;

class PelaporanPekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $harianList  = TargetKinerjaHarian::take(3)->get();
        $kontrakUnit = KontrakUnit::first();
        $users       = User::where('is_admin', 0)->take(3)->get();

        foreach ($harianList as $index => $h) {
            $pelapor = $users[$index] ?? $users->first();

            PelaporanPekerjaan::create([
                // Kolom PELAPORAN_KINERJA (ERD)
                'ku_id'          => $kontrakUnit?->id,
                'user_id'        => $pelapor?->id,
                'tanggal'        => now()->subDays(rand(1, 30))->toDateString(),
                'deskripsi'      => 'Telah dilakukan kegiatan: ' . $h->pekerjaan,
                'menit_kerja'    => $h->waktu_minutes ?? 60,
                'realisasi'      => 'Selesai dilaksanakan sesuai rencana.',
                'evidence'       => null,
                'status'         => 'pending',
                'catatan_atasan' => null,
                'atasan_id'      => null,

                // Kolom lama (backward compat)
                'target_harian_id'        => $h->id,
                'referensi_set_target_id' => $h->id,
                'realisasi_jumlah'        => $h->jumlah ?? 1,
                'realisasi_waktu_minutes' => $h->waktu_minutes ?? 0,
                'approved_jumlah'         => null,
                'approved_waktu_minutes'  => null,
                'created_by'              => $pelapor?->id,
                'approved_by'             => null,
            ]);
        }
    }
}
