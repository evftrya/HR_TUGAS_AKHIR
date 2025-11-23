<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudiLanjut;
use App\Models\User;
use Illuminate\Support\Str;

class StudiLanjutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 4 user aktif secara random
        $users = User::where('is_active', 1)->inRandomOrder()->take(4)->get();

        if ($users->count() < 4) {
            $this->command->warn('Tidak cukup user aktif untuk membuat 4 data studi lanjut');
            return;
        }

        $studiLanjutData = [
            [
                'users_id' => $users[0]->id,
                'jenjang' => 'S2',
                'program_studi' => 'Teknik Informatika',
                'universitas' => 'Institut Teknologi Bandung',
                'negara' => 'Indonesia',
                'tanggal_mulai' => '2023-08-01',
                'tanggal_selesai' => '2025-07-31',
                'status' => 'Sedang Berjalan',
                'sumber_dana' => 'LPDP',
                'keterangan' => 'Beasiswa penuh dari LPDP untuk program studi S2 Teknik Informatika',
            ],
            [
                'users_id' => $users[1]->id,
                'jenjang' => 'S3',
                'program_studi' => 'Manajemen Pendidikan',
                'universitas' => 'Universitas Pendidikan Indonesia',
                'negara' => 'Indonesia',
                'tanggal_mulai' => '2022-09-01',
                'tanggal_selesai' => '2025-08-31',
                'status' => 'Sedang Berjalan',
                'sumber_dana' => 'Beasiswa Telkom University',
                'keterangan' => 'Program doktoral dengan fokus riset manajemen pendidikan tinggi',
            ],
            [
                'users_id' => $users[2]->id,
                'jenjang' => 'S2',
                'program_studi' => 'Computer Science',
                'universitas' => 'National University of Singapore',
                'negara' => 'Singapore',
                'tanggal_mulai' => '2021-08-01',
                'tanggal_selesai' => '2023-07-31',
                'status' => 'Selesai',
                'sumber_dana' => 'Dana Pribadi',
                'keterangan' => 'Telah menyelesaikan program S2 dengan predikat cum laude',
            ],
            [
                'users_id' => $users[3]->id,
                'jenjang' => 'S3',
                'program_studi' => 'Data Science',
                'universitas' => 'University of Melbourne',
                'negara' => 'Australia',
                'tanggal_mulai' => '2024-02-01',
                'tanggal_selesai' => null,
                'status' => 'Cuti',
                'sumber_dana' => 'Australia Awards Scholarship',
                'keterangan' => 'Sedang cuti akademik untuk menyelesaikan penelitian',
            ],
        ];

        foreach ($studiLanjutData as $data) {
            StudiLanjut::create($data);
        }

        $this->command->info('4 data studi lanjut berhasil dibuat');
    }
}
