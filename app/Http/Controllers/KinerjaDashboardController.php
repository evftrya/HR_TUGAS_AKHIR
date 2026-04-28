<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetKinerja;
use App\Models\TargetKinerjaHarian;
use App\Models\PelaporanPekerjaan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KinerjaDashboardController extends Controller
{
    public function index()
    {
        // Ringkasan KPI
        $totalTarget    = TargetKinerja::where('is_active', 1)->count();
        $laporanPending = PelaporanPekerjaan::where('status', 'pending')->count();
        $totalHarian    = TargetKinerjaHarian::where('is_active', 1)->count();

        // Laporan terkini
        $laporanTerkini = PelaporanPekerjaan::with(['pelapor', 'targetHarian'])
            ->latest()->take(10)->get();

        // 1. Ambil data 90 hari terakhir (3 Bulan) + Top 3 Contributors per hari
        $rawReports = PelaporanPekerjaan::where('status', 'approved')
            ->where('pelaporan_pekerjaan.created_at', '>=', now()->subDays(90))
            ->join('users', 'users.id', '=', 'pelaporan_pekerjaan.user_id')
            ->select(
                DB::raw('DATE(pelaporan_pekerjaan.created_at) as date'),
                'users.nama_lengkap',
                'pelaporan_pekerjaan.approved_waktu_minutes'
            )
            ->get();

        // 2. Kalkulasi Per Hari
        $dailyData = [];
        foreach ($rawReports as $report) {
            $date = $report->date;
            if (!isset($dailyData[$date])) {
                $dailyData[$date] = ['total_min' => 0, 'users' => []];
            }
            $dailyData[$date]['total_min'] += $report->approved_waktu_minutes;
            
            // Simpan akumulasi per user untuk mencari top contributor
            $name = explode(' ', $report->nama_lengkap)[0]; 
            $dailyData[$date]['users'][$name] = ($dailyData[$date]['users'][$name] ?? 0) + $report->approved_waktu_minutes;
        }

        // 3. Bandingkan dengan 90 hari sebelumnya untuk Tren
        $totalMinutesCurrent = PelaporanPekerjaan::where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(90))
            ->sum('approved_waktu_minutes');
            
        $totalMinutesPast = PelaporanPekerjaan::where('status', 'approved')
            ->whereBetween('created_at', [now()->subDays(180), now()->subDays(91)])
            ->sum('approved_waktu_minutes');

        $trend = 0;
        if ($totalMinutesPast > 0) {
            $trend = (($totalMinutesCurrent - $totalMinutesPast) / $totalMinutesPast) * 100;
        }

        // 4. Bangun Heatmap Data (90 Hari)
        $heatmapData = [];
        $peakMinutes = 0;
        $peakDate = '-';
        $startDate = now()->subDays(89);

        for ($date = $startDate->copy(); $date->lte(now()); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $data = $dailyData[$dateStr] ?? ['total_min' => 0, 'users' => []];
            
            // Cari Top 3
            arsort($data['users']);
            $topThree = array_slice(array_keys($data['users']), 0, 3);
            $othersCount = max(0, count($data['users']) - 3);

            $minutes = $data['total_min'];
            if ($minutes > $peakMinutes) {
                $peakMinutes = $minutes;
                $peakDate = $date->format('d M Y');
            }

            $heatmapData[] = [
                'x' => $dateStr,
                'y' => round($minutes / 60, 1),
                'contributors' => count($data['users']),
                'top_names' => implode(', ', $topThree) . ($othersCount > 0 ? " +$othersCount" : '')
            ];
        }

        $stats = [
            'total_hours' => round($totalMinutesCurrent / 60),
            'avg_daily'   => round(($totalMinutesCurrent / 90) / 60, 1),
            'trend'       => round($trend, 1),
            'peak_day'    => $peakDate,
            'peak_value'  => round($peakMinutes / 60, 1)
        ];

        return view('kinerja_pegawai.index', compact(
            'totalTarget', 'laporanPending', 'totalHarian', 'laporanTerkini', 'heatmapData', 'stats'
        ));
    }
}
