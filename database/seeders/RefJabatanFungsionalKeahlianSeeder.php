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
            ['nama_jfk' => 'Ahli Pertama','urut' => '1'],
            ['nama_jfk' => 'Ahli Muda','urut' => '2'],
            ['nama_jfk' => 'Ahli Madya','urut' => '3'],
            ['nama_jfk' => 'Ahli Utama','urut' => '4'],
        ];

        foreach ($data as $item) {
            refJabatanFungsionalKeahlian::create($item);
        }
    }
}
