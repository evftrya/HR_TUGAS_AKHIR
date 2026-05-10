<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TargetKinerja;
use App\Models\TargetKinerjaHarian;
use App\Models\PelaporanPekerjaan;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerformanceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua unit dan pegawai
        $units = Unit::all();
        $pegawais = User::where('role', 'pegawai')->get();

        if ($pegawais->isEmpty()) {
            $pegawais = User::limit(10)->get();
        }

        // 2. Buat Master KM & SM (Sample)
        $masterTargets = [];
        $indikators = [
            ['nama' => 'Peningkatan Publikasi Internasional', 'jenis' => 'Kontrak Manajemen', 'satuan' => 'Dokumen'],
            ['nama' => 'Indeks Kepuasan Layanan Akademik', 'jenis' => 'Sasaran Mutu', 'satuan' => 'Skor'],
            ['nama' => 'Rata-rata Waktu Kelulusan Mahasiswa', 'jenis' => 'Kontrak Manajemen', 'satuan' => 'Tahun'],
            ['nama' => 'Persentase Dosen Studi Lanjut S3', 'jenis' => 'Sasaran Mutu', 'satuan' => '%'],
        ];

        foreach ($indikators as $ind) {
            $masterTargets[] = TargetKinerja::create([
                'nama_kpi' => $ind['nama'],
                'jenis' => $ind['jenis'],
                'satuan' => $ind['satuan'],
                'tahun' => 2025,
                'is_active' => 1,
                'responsibility_id' => $units->random()->id ?? null,
                'tw1_target' => rand(10, 50),
                'tw1_bobot' => 25,
                'tw2_target' => rand(10, 50),
                'tw2_bobot' => 25,
                'tw3_target' => rand(10, 50),
                'tw3_bobot' => 25,
                'tw4_target' => rand(10, 50),
                'tw4_bobot' => 25,
                'start' => '2025-01-01',
                'end' => '2025-12-31',
            ]);
        }

        // 3. Untuk setiap pegawai, buat target harian dan laporannya
        foreach ($pegawais as $pegawai) {
            // Buat 3 Target Kinerja Individu untuk setiap pegawai
            for ($i = 1; $i <= 3; $i++) {
                $targetHarian = TargetKinerjaHarian::create([
                    'pekerjaan' => 'Tugas ' . $i . ' untuk ' . $pegawai->nama_lengkap,
                    'kontrak_type' => 'pribadi',
                    'satuan' => 'Laporan',
                    'target' => rand(5, 20),
                    'bobot' => rand(5, 15),
                    'waktu' => '2 Jam',
                    'waktu_minutes' => 120,
                    'is_active' => 1,
                    'user_id' => $pegawai->id,
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth(),
                ]);

                // Assign pegawai ke target harian (pivot table)
                $targetHarian->pegawai()->attach($pegawai->id, [
                    'tanggal_mulai' => Carbon::now()->startOfMonth(),
                    'tanggal_selesai' => Carbon::now()->endOfMonth(),
                    'status' => 'in_progress'
                ]);

                // Hubungkan ke 1-2 Master KM/SM (Many-to-Many via pivot)
                $randomMasters = collect($masterTargets)->random(rand(1, 2))->pluck('id');
                $targetHarian->indukKpi()->sync($randomMasters);

                // 4. Buat Laporan Harian (Log Kinerja)
                // Buat laporan untuk 5 hari terakhir
                for ($d = 0; $d < 5; $d++) {
                    $tanggal = Carbon::now()->subDays($d);
                    $waktuKlaim = rand(60, 180);
                    $isValidated = rand(0, 1); // 50% chance approved

                    PelaporanPekerjaan::create([
                        'target_harian_id' => $targetHarian->id,
                        'created_by' => $pegawai->id,
                        'user_id' => $pegawai->id,
                        'tanggal' => $tanggal,
                        'realisasi' => 'Telah menyelesaikan progres pengerjaan pada hari ke-' . ($d + 1),
                        'realisasi_jumlah' => rand(1, 3),
                        'realisasi_waktu_minutes' => $waktuKlaim,
                        'waktu_pengerjaan' => $waktuKlaim,
                        'status' => $isValidated ? 'approved' : 'pending',
                        'approved_jumlah' => $isValidated ? rand(1, 3) : null,
                        'approved_waktu_minutes' => $isValidated ? $waktuKlaim : 0,
                        'waktu_validasi_atasan' => $isValidated ? $waktuKlaim : null,
                        'approved_by' => $isValidated ? User::where('role', 'atasan')->first()?->id : null,
                        'created_at' => $tanggal,
                    ]);
                }
            }
        }
    }
}
