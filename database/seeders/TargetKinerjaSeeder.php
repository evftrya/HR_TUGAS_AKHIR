<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetKinerja;

class TargetKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama_kpi'             => 'Peningkatan Publikasi Internasional',
                'keterangan'           => 'Meningkatkan jumlah publikasi pada jurnal bereputasi',
                'bobot'                => 30.00,
                'satuan'               => 'Publikasi',
                'tahun'                => 2025,
                'is_active'            => 1,
                'responsibility'       => 'Publikasi dan penelitian',
                'target_percent'       => 20,
                'status'               => 'institusi',
                'unit_penanggung_jawab'=> 'Fakultas Teknologi Informasi',
                'periode'              => '2025',
                'start'                => '2025-01-01',
                'end'                  => '2025-12-31',
            ],
            [
                'nama_kpi'             => 'Kegiatan Pengabdian Masyarakat',
                'keterangan'           => 'Pelaksanaan kegiatan pengabdian masyarakat oleh prodi',
                'bobot'                => 20.00,
                'satuan'               => 'Kegiatan',
                'tahun'                => 2025,
                'is_active'            => 1,
                'responsibility'       => 'Pengabdian',
                'target_percent'       => 10,
                'status'               => 'unit',
                'unit_penanggung_jawab'=> 'Prodi Sistem Informasi',
                'periode'              => '2025',
                'start'                => '2025-01-01',
                'end'                  => '2025-12-31',
            ],
            [
                'nama_kpi'             => 'Kinerja Pribadi Dosen',
                'keterangan'           => 'Target kinerja individu dosen',
                'bobot'                => 50.00,
                'satuan'               => 'Unit',
                'tahun'                => 2025,
                'is_active'            => 1,
                'responsibility'       => 'Dosen',
                'target_percent'       => 50,
                'status'               => 'pribadi',
                'unit_penanggung_jawab'=> 'Dosen yang bersangkutan',
                'periode'              => '2025',
                'start'                => '2025-01-01',
                'end'                  => '2025-12-31',
            ],
        ];

        foreach ($items as $data) {
            TargetKinerja::firstOrCreate(
                ['nama_kpi' => $data['nama_kpi'], 'tahun' => $data['tahun']],
                $data
            );
        }
    }
}
