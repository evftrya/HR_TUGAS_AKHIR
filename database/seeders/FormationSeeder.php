<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $LEVEL_DIREKTUR              = 'f091dbb2-7532-4c5e-b94f-9e4bc045dc7a';
        $LEVEL_WAKIL_DIREKTUR        = '0de96d16-c872-4195-9f45-e837d659b571';
        $LEVEL_KEPALA_BAGIAN         = '316e0668-9bb5-4f27-867d-5a209cbcd228';
        $LEVEL_DEKAN                 = 'be5adb40-ae9f-4fa4-aeeb-d6b37394b1e7';
        $LEVEL_KEPALA_URUSAN         = '037b9e77-a77b-4bee-820d-e52b62c74c92';
        $LEVEL_KEPALA_PRODI          = 'e33399cf-0049-45bb-b9e7-db5cd8661b18';
        $LEVEL_ANGGOTA_BAGIAN        = '05e59440-c012-4b20-83e7-eb841bb44525';
        $LEVEL_ANGGOTA_PRODI         = '813b1182-c975-406a-a60a-e75b7ace942d';
        $formasiIds = [
            1  => 'a1f3c4f4-01e3-4e59-ae0a-91ac0f301101',
            2  => 'b2d6c2a1-93cb-4c3e-bb12-8e5af7542102',
            3  => 'c3af0c7b-45de-4f73-bc9a-0d9fcd9b3103',
            4  => 'd4b8f5e9-22ef-44af-9a21-8123df453104',
            5  => 'e5c7a8d3-66d1-4cd8-8b1f-927fa9e76105',
            6  => 'f6d4b9a7-88f3-4c9b-ae55-b75ebfa98106',
            7  => 'a7e2c3f1-91d4-442e-a915-c78df9b89107',
            8  => 'b8f3d4a9-52c1-4e7a-ab20-11afe7fa1108',
            9  => 'c9a4e5b8-10ac-43f9-bbb3-aa23e5cd2109',
            10 => 'da05f6c7-55fd-4cd8-87b2-ff89bcda3110',
            11 => 'eb16a7d5-77c1-49f5-9543-118cbced4111',
            12 => 'fc27b8e3-88f4-4d70-baf3-227aeedf5112',
            13 => 'ad38c9f9-19d6-4bb8-9f21-332fdfe66113',
            14 => 'be49daf8-20f8-49fc-84a2-449cfffa7114',
            15 => 'cf5aebc7-31e9-4dad-a155-55abcffb8115',
            16 => 'd06bfcf5-42fa-4ccf-9b77-66cbdffc9116',
            17 => 'e17d0da3-53ab-4fd9-bf88-77dcaffda117',
        ];

        $formasi = [
            [
                'id'                 => $formasiIds[1],
                'nama_formasi'       => 'Direktur',
                'level_id'           => $LEVEL_DIREKTUR,
                'atasan_formasi_id'  => null,
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[2],
                'nama_formasi'       => 'Wakil Direktur',
                'level_id'           => $LEVEL_WAKIL_DIREKTUR,
                'atasan_formasi_id'  => $formasiIds[1],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 3,
            ],
            [
                'id'                 => $formasiIds[3],
                'nama_formasi'       => 'Wakil Direktur',
                'level_id'           => $LEVEL_WAKIL_DIREKTUR,
                'atasan_formasi_id'  => $formasiIds[1],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 2,
            ],
            [
                'id'                 => $formasiIds[4],
                'nama_formasi'       => 'Wakil Direktur',
                'level_id'           => $LEVEL_WAKIL_DIREKTUR,
                'atasan_formasi_id'  => $formasiIds[1],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 4,
            ],
            [
                'id'                 => $formasiIds[5],
                'nama_formasi'       => 'Kepala Bagian Keuangan',
                'level_id'           => $LEVEL_KEPALA_BAGIAN,
                'atasan_formasi_id'  => $formasiIds[2],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[6],
                'nama_formasi'       => 'Kepala Urusan Keuangan',
                'level_id'           => $LEVEL_KEPALA_URUSAN,
                'atasan_formasi_id'  => $formasiIds[5],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[7],
                'nama_formasi'       => 'Anggota Keuangan',
                'level_id'           => $LEVEL_ANGGOTA_BAGIAN,
                'atasan_formasi_id'  => $formasiIds[6],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 6,
            ],
            [
                'id'                 => $formasiIds[8],
                'nama_formasi'       => 'Kepala Bagian SDM',
                'level_id'           => $LEVEL_KEPALA_BAGIAN,
                'atasan_formasi_id'  => $formasiIds[2],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[9],
                'nama_formasi'       => 'Kepala Urusan SDM',
                'level_id'           => $LEVEL_KEPALA_URUSAN,
                'atasan_formasi_id'  => $formasiIds[8],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[10],
                'nama_formasi'       => 'Anggota SDM',
                'level_id'           => $LEVEL_ANGGOTA_BAGIAN,
                'atasan_formasi_id'  => $formasiIds[9],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 6,
            ],
            [
                'id'                 => $formasiIds[11],
                'nama_formasi'       => 'Dekan Program Studi Teknik Informatika',
                'level_id'           => $LEVEL_DEKAN,
                'atasan_formasi_id'  => $formasiIds[4],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[12],
                'nama_formasi'       => 'Dekan Fakultas Informatika',
                'level_id'           => $LEVEL_DEKAN,
                'atasan_formasi_id'  => $formasiIds[4],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[13],
                'nama_formasi'       => 'Dekan Fakultas Bisnis',
                'level_id'           => $LEVEL_DEKAN,
                'atasan_formasi_id'  => $formasiIds[4],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[14],
                'nama_formasi'       => 'Kaprodi Rekayasa Perangkat Lunak',
                'level_id'           => $LEVEL_KEPALA_PRODI,
                'atasan_formasi_id'  => $formasiIds[12],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[15],
                'nama_formasi'       => 'Anggota Prodi RPL',
                'level_id'           => $LEVEL_ANGGOTA_PRODI,
                'atasan_formasi_id'  => $formasiIds[14],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 8,
            ],
            [
                'id'                 => $formasiIds[16],
                'nama_formasi'       => 'Kaprodi Sistem Informasi',
                'level_id'           => $LEVEL_KEPALA_PRODI,
                'atasan_formasi_id'  => $formasiIds[12],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 1,
            ],
            [
                'id'                 => $formasiIds[17],
                'nama_formasi'       => 'Anggota Prodi SI',
                'level_id'           => $LEVEL_ANGGOTA_PRODI,
                'atasan_formasi_id'  => $formasiIds[16],
                'bagian'             => null,
                'prodi'              => null,
                'fakultas'           => null,
                'kuota'              => 8,
            ],
        ];

        foreach ($formasi as $item) {
            Formation::create($item);
        }

    }
}
