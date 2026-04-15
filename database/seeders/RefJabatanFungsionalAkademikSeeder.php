<?php

namespace Database\Seeders;

use App\Models\RefJabatanFungsionalAkademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefJabatanFungsionalAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_jabatan' => 'Asisten Ahli', 'minimal' => 'III/b','maximal'=>'III/c'],
            ['nama_jabatan' => 'Lektor', 'minimal' => 'III/d','maximal'=>'IV/a'],
            ['nama_jabatan' => 'Lektor Kepala', 'minimal' => 'IV/b','maximal'=>'IV/c'],
            ['nama_jabatan' => 'Guru Besar (Profesor)', 'minimal' => 'IV/d','maximal'=>'IV/e'],
        ];

        foreach ($data as $item) {
            refJabatanFungsionalAkademik::create($item);
        }
    }
}
