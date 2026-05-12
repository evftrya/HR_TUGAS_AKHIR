<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetKinerja;

class TargetKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus pengisian kolom target dan bobot global (sudah di-drop)
        // Tambahkan field baru sesuai skema
        TargetKinerja::create([
            'nama_kpi'              => 'Peningkatan Publikasi Internasional Scopus Q1/Q2',
            'keterangan'            => 'Meningkatkan jumlah publikasi pada jurnal bereputasi internasional',
            'jenis'                 => 'Kontrak Manajemen',
            'satuan'                => 'Dokumen',
            'tahun'                 => 2025,
            'is_active'             => 1,
            'tw1_target'            => 90,
            'tw1_bobot'             => 5,
            'tw2_target'            => 90,
            'tw2_bobot'             => 5,
            'tw3_target'            => 90,
            'tw3_bobot'             => 5,
            'tw4_target'            => 90,
            'tw4_bobot'             => 5,
            'status'                => 'institusi',
            'unit_penanggung_jawab' => 'Direktorat Riset',
            'periode'               => '2025',
            'start'                 => '2025-01-01',
            'end'                   => '2025-12-31',
        ]);

        TargetKinerja::create([
            'nama_kpi'              => 'Indeks Kepuasan Layanan Mahasiswa',
            'keterangan'            => 'Mengukur tingkat kepuasan mahasiswa terhadap layanan akademik',
            'jenis'                 => 'Sasaran Mutu',
            'satuan'                => 'Skor',
            'tahun'                 => 2025,
            'is_active'             => 1,
            'tw1_target'            => 85,
            'tw1_bobot'             => 10,
            'tw2_target'            => 85,
            'tw2_bobot'             => 10,
            'tw3_target'            => 85,
            'tw3_bobot'             => 10,
            'tw4_target'            => 85,
            'tw4_bobot'             => 10,
            'status'                => 'unit',
            'unit_penanggung_jawab' => 'Biro Akademik',
            'periode'               => '2025',
            'start'                 => '2025-01-01',
            'end'                   => '2025-12-31',
        ]);
    }
}
