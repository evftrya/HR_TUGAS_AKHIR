<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkumulasiKinerja;
use App\Models\Presensi;
use App\Models\KinerjaSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function settings()
    {
        // 2H2: Presence Settings
        // Only admin can access (Middleware should handle this, but adding check here too)
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $maxCheckIn = KinerjaSetting::get('max_check_in_time', '08:00');
        return view('kinerja_pegawai.presensi.settings', compact('maxCheckIn'));
    }

    public function updateSettings(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'max_check_in_time' => 'required|date_format:H:i'
        ]);

        KinerjaSetting::set('max_check_in_time', $request->max_check_in_time, 'string', 'Batas jam masuk maksimal (format HH:mm)');

        return redirect()->back()->with('success', 'Pengaturan presensi berhasil diperbarui');
    }

    public function tardinessReport(Request $request)
    {
        // 2H1: Tardiness Report
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $maxTime = KinerjaSetting::get('max_check_in_time', '08:00');

        $report = User::where('is_admin', false)
            ->with(['presensis' => function($q) use ($month, $year) {
                $q->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
            }])
            ->get()
            ->map(function($user) use ($maxTime) {
                $logs = $user->presensis;
                $tardinessCount = $logs->filter(function($log) use ($maxTime) {
                    return $log->jam_masuk > $maxTime;
                })->count();

                $avgCheckIn = null;
                if ($logs->count() > 0) {
                    $totalMinutes = $logs->sum(function($log) {
                        $parts = explode(':', $log->jam_masuk);
                        return ($parts[0] * 60) + $parts[1];
                    });
                    $avgMinutes = $totalMinutes / $logs->count();
                    $avgCheckIn = sprintf('%02d:%02d', floor($avgMinutes / 60), $avgMinutes % 60);
                }

                return [
                    'user' => $user,
                    'tardiness_count' => $tardinessCount,
                    'avg_check_in' => $avgCheckIn,
                ];
            });

        return view('kinerja_pegawai.presensi.tardiness', compact('report', 'maxTime', 'month', 'year'));
    }
}
