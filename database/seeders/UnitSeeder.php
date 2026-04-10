<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['nama_unit' => 'Fakultas Teknologi Informasi',      'kode_unit' => 'FTI'],
            ['nama_unit' => 'Fakultas Teknik Elektro',            'kode_unit' => 'FTE'],
            ['nama_unit' => 'Fakultas Rekayasa Industri',         'kode_unit' => 'FRI'],
            ['nama_unit' => 'Fakultas Komunikasi & Bisnis',       'kode_unit' => 'FKB'],
            ['nama_unit' => 'Prodi Sistem Informasi',             'kode_unit' => 'SI'],
            ['nama_unit' => 'Prodi Teknik Informatika',           'kode_unit' => 'TI'],
            ['nama_unit' => 'Prodi Manajemen',                   'kode_unit' => 'MNJ'],
            ['nama_unit' => 'Biro Sumber Daya Manusia',          'kode_unit' => 'BSDM'],
            ['nama_unit' => 'Biro Keuangan',                     'kode_unit' => 'BK'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['kode_unit' => $unit['kode_unit']], $unit);
        }
    }
}
