<?php

namespace Database\Seeders;

use App\Models\RefPangkatGolongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefPangkatGolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     ['pangkat' => 'Asisten Ahli', 'golongan' => 'III/b'],
        //     ['pangkat' => 'Lektor', 'golongan' => 'III/c'],
        //     ['pangkat' => 'Lektor Kepala', 'golongan' => 'IV/a'],
        //     ['pangkat' => 'Guru Besar (Profesor)', 'golongan' => 'IV/c'],
        // ];

        $data = [
            ['pangkat' => 'Penata', 'golongan' => 'III/c','urut' => '1'],
            ['pangkat' => 'Penata Muda Tk. I', 'golongan' => 'III/b','urut' => '2'],
            ['pangkat' => 'Penata Tk. I', 'golongan' => 'IV/c','urut' => '3'],
            ['pangkat' => 'Pembina Tk. I', 'golongan' => 'IV/b','urut' => '4'],
            ['pangkat' => 'Pembina Utama Muda', 'golongan' => 'IV/c','urut' => '5'],
        ];

        foreach ($data as $item) {
            RefPangkatGolongan::create($item);
        }
    }
}
