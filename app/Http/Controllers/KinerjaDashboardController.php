<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetKinerja;
use App\Models\TargetKinerjaHarian;
use App\Models\PelaporanPekerjaan;

class KinerjaDashboardController extends Controller
{
    public function index()
    {
        // Ringkasan KPI
        $totalTarget    = TargetKinerja::where('is_active', 1)->count();
        $laporanPending = PelaporanPekerjaan::where('status', 'pending')->count();
        $totalHarian    = TargetKinerjaHarian::where('is_active', 1)->count();

        // Laporan terkini (10 data terakhir)
        $laporanTerkini = PelaporanPekerjaan::with(['pelapor', 'targetHarian'])
            ->latest()
            ->take(10)
            ->get();

        return view('kinerja_pegawai.index', compact(
            'totalTarget',
            'laporanPending',
            'totalHarian',
            'laporanTerkini'
        ));
    }
}
