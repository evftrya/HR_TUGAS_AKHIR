<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\TargetKinerja;
use Illuminate\Support\Facades\DB;

class TargetKinerjaLaporanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa user (dosen)
        $users = User::factory()->count(5)->create();

        // Buat beberapa target kinerja
        $targets = [
            ['nama' => 'Publikasi Jurnal', 'keterangan' => 'Publikasi di jurnal bereputasi', 'bobot' => 30],
            ['nama' => 'Pengabdian Masyarakat', 'keterangan' => 'Kegiatan pengabdian', 'bobot' => 20],
            ['nama' => 'Mengajar', 'keterangan' => 'Mengajar minimal 12 SKS', 'bobot' => 40],
        ];
        foreach ($targets as $data) {
            $target = TargetKinerja::create(array_merge($data, ['is_active' => true]));
            // Assign ke beberapa user
            foreach ($users->random(3) as $user) {
                DB::table('target_kinerja_pegawai')->insert([
                    'target_kinerja_id' => $target->id,
                    'user_id' => $user->id,
                    'tanggal_mulai' => now()->subDays(rand(10, 30)),
                    'tanggal_selesai' => now()->addDays(rand(5, 20)),
                    'status' => collect(['pending','in_progress','completed','cancelled'])->random(),
                    'catatan' => Str::random(20),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
