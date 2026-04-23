<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkumulasiKinerja;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $query = AkumulasiKinerja::with('user');

        // Filtering by name / employee_id
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filter by month / year
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Sorting
        $items = $query->orderBy('year', 'desc')
                       ->orderBy('month', 'desc')
                       ->orderBy('fullname', 'asc')
                       ->paginate(15)
                       ->withQueryString();

        // Summary statistics
        $summary = [
            'total_pegawai' => AkumulasiKinerja::distinct('employee_id')->count('employee_id'),
            'avg_jam_kerja' => round(AkumulasiKinerja::avg('jam_kerja'), 1),
            'avg_kehadiran' => round(AkumulasiKinerja::avg('kehadiran'), 1),
            'masalah_tap'   => AkumulasiKinerja::where('tidak_tap_pulang', '>', 0)->count(),
        ];

        return view('kinerja_pegawai.presensi.index', compact('items', 'summary'));
    }
}
