<?php

namespace Database\Seeders;

use App\Models\RefJabatanFungsionalKeahlian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefJabatanFungsionalKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_jfk' => 'Ahli Pertama'],
            ['nama_jfk' => 'Ahli Muda'],
            ['nama_jfk' => 'Ahli Madya'],
            ['nama_jfk' => 'Ahli Utama'],
        ];

        foreach ($data as $item) {
            refJabatanFungsionalKeahlian::create($item);
        }
    }
}
