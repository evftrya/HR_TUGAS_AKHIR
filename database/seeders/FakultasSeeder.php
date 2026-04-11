<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        $data =
            [
                [
                    "id" => "e4414f52-706d-4682-95f7-876e4695015e",
                    "kode" => "FKB",
                    "position_name" => "Fakultas Komunikasi dan Bisnis",
                    "type_work_position" => "Fakultas",
                    "type_pekerja" => "Dosen"
                ],
                [
                    "id" => "7649d63b-6e71-4171-884c-352019777174",
                    "kode" => "FIK",
                    "position_name" => "Fakultas Industri Kreatif",
                    "type_work_position" => "Fakultas",
                    "type_pekerja" => "Dosen"
                ],
                [
                    "id" => "99354067-172c-4740-985f-8255e2be1960",
                    "kode" => "FIT",
                    "position_name" => "Fakultas Ilmu Terapan",
                    "type_work_position" => "Fakultas",
                    "type_pekerja" => "Dosen"
                ]
            ];





        foreach ($data as $item) {
            // dd($item);
            Fakultas::create($item);
        }
    }
}
