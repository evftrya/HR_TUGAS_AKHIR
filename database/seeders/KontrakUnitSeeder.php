<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KontrakUnit;
use App\Models\TargetKinerja;
use App\Models\Unit;

class KontrakUnitSeeder extends Seeder
{
    public function run(): void
    {
        // Pasangkan setiap TargetKinerja ke unit yang relevan
        $targets = TargetKinerja::all();
        $units   = Unit::all()->keyBy('kode_unit');

        if ($targets->isEmpty() || $units->isEmpty()) {
            return;
        }

        // Mapping: nama_kpi → unit yang bertanggung jawab
        $mappings = [
            'Peningkatan Publikasi Internasional' => [
                ['kode' => 'FTI',  'target_angka' => 20],
                ['kode' => 'FTE',  'target_angka' => 15],
            ],
            'Kegiatan Pengabdian Masyarakat' => [
                ['kode' => 'SI',   'target_angka' => 5],
                ['kode' => 'TI',   'target_angka' => 5],
            ],
            'Kinerja Pribadi Dosen' => [
                ['kode' => 'FTI',  'target_angka' => 100],
            ],
        ];

        foreach ($targets as $target) {
            $unitList = $mappings[$target->nama_kpi] ?? [];
            foreach ($unitList as $entry) {
                $unit = $units->get($entry['kode']);
                if (!$unit) continue;

                KontrakUnit::firstOrCreate(
                    ['km_id' => $target->id, 'unit_id' => $unit->id],
                    ['target_angka' => $entry['target_angka']]
                );
            }
        }
    }
}
