<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetKinerjaHarian;
use App\Models\PelaporanPekerjaan;
use App\Models\User;
use Carbon\Carbon;

class AssignedReportSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua Target Kinerja (Individu) yang sudah memiliki penugasan pegawai
        $targets = TargetKinerjaHarian::has('pegawai')->with('pegawai')->get();
        
        $atasan = User::where('role', 'atasan')->first();
        $admin = User::where('is_admin', true)->first();
        $reviewerId = $atasan ? $atasan->id : ($admin ? $admin->id : null);

        $this->command->info('Memulai seeding laporan untuk ' . $targets->count() . ' target yang sudah di-assign...');

        foreach ($targets as $target) {
            foreach ($target->pegawai as $pegawai) {
                // Untuk setiap penugasan, buat 10 laporan acak dalam 30 hari terakhir
                for ($i = 0; $i < 10; $i++) {
                    $tanggal = Carbon::now()->subDays(rand(0, 30));
                    $waktuKlaim = rand(30, 240); // 30 menit sampai 4 jam
                    
                    // Tentukan status acak
                    $randStatus = rand(1, 10);
                    if ($randStatus <= 7) {
                        $status = 'approved';
                    } elseif ($randStatus <= 9) {
                        $status = 'pending';
                    } else {
                        $status = 'rejected';
                    }

                    PelaporanPekerjaan::create([
                        'target_harian_id' => $target->id,
                        'created_by'       => $pegawai->id,
                        'user_id'          => $pegawai->id, // FK ERD
                        'tanggal'          => $tanggal,    // Tanggal ERD
                        'deskripsi'        => 'Melaksanakan ' . $target->pekerjaan . ' - Iterasi ke-' . ($i + 1),
                        'menit_kerja'      => $waktuKlaim,
                        'realisasi'        => 'Hasil pengerjaan ' . $target->pekerjaan . ' telah diselesaikan dengan baik sesuai target.',
                        'realisasi_jumlah' => rand(1, 5),
                        'realisasi_waktu_minutes' => $waktuKlaim,
                        'waktu_pengerjaan' => $waktuKlaim, // Klaim pegawai
                        'status'           => $status,
                        'pencapaian_percent' => rand(80, 100),
                        'evidence'         => 'https://dummyimage.com/600x400/0070ff/fff&text=Evidence+' . ($i+1),
                        
                        // Data Approval (Jika Approved)
                        'approved_jumlah'        => $status === 'approved' ? rand(1, 5) : null,
                        'approved_waktu_minutes' => $status === 'approved' ? $waktuKlaim : 0, // Non-nullable, set 0 if not approved
                        'waktu_validasi_atasan'  => $status === 'approved' ? $waktuKlaim : null,
                        'approved_by'            => $status === 'approved' ? $reviewerId : null,
                        'atasan_id'              => $status === 'approved' ? $reviewerId : null,
                        'catatan_atasan'         => $status === 'approved' ? 'Pekerjaan sangat baik dan efisien.' : ($status === 'rejected' ? 'Bukti kurang lengkap.' : null),
                        
                        'created_at' => $tanggal,
                        'updated_at' => $status === 'approved' ? $tanggal->addHours(rand(1, 24)) : $tanggal,
                    ]);
                }
            }
        }

        $this->command->info('Seeding laporan selesai!');
    }
}
