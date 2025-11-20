<?php

namespace App\Http\Controllers\Dupak;

use App\Http\Controllers\Controller;
use App\Models\Dupak\Pengajuan;
use App\Models\Dosen;
use App\Models\refJabatanFungsionalAkademik;
use App\Models\riwayatJabatanFungsionalAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the DUPAK dashboard with necessary data, filtered by user role.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. --- Get Dosen ID Mapping ---
        // This links the authenticated User (users table) to the Dosen record.
        $dosen = Dosen::where('users_id', $user->id)->first();
        $dosenId = $dosen->id ?? null; // ID used for filtering submissions (idDosen)

        // 2. --- KUM Calculation and Formatting ---
        $currentKum = $user->kum ?? 0;
        $goalKum = $user->kum_goal ?? 200;

        $percent = $goalKum > 0 ? min(100, ($currentKum / $goalKum) * 100) : 0;
        $remaining = max(0, $goalKum - $currentKum);

        // mengambil jabatan dari user saat ini dari riwayat jfa terbaru
        $riwayat_jabatan_saat_ini = riwayatJabatanFungsionalAkademik::where('dosen_id', $dosen->id)
            ->latest()
            ->first();

        // get nama jabatan dari refJabatanFungsionalAkademik
        if ($riwayat_jabatan_saat_ini) {
            $ref_jfa = refJabatanFungsionalAkademik::find($riwayat_jabatan_saat_ini->ref_jfa_id);
            $riwayat_jabatan_saat_ini = $ref_jfa ? $ref_jfa->nama_jabatan : null;
        }

        // Determine status color (Tailwind classes)
        if ($percent >= 100) {
            $statusColor = 'bg-green-600';
        } elseif ($percent >= 60) {
            $statusColor = 'bg-yellow-500';
        } else {
            $statusColor = 'bg-indigo-600';
        }

        // Format the last updated time
        $updatedAt = $user->kum_updated_at
            ? Carbon::parse($user->kum_updated_at)->diffForHumans()
            : 'Belum pernah diperbarui';

        // 3. --- Pengajuan Query with Role-Based Filtering ---
        $pengajuanQuery = Pengajuan::with([
            'dosen',          // relasi ke Dosen
            'dosen.pegawai'   // relasi ke User (nama_lengkap)
        ])->orderBy('id', 'desc');

        // role based regulations
        // 1. if user is dosen, show their own submissions only, tracked by idDosen
        // 2. if user is dosen but has no Dosen record, show none.
        // 3. if user is admin, show all submissions.
        if ($user && !$user->is_admin) { // user is dosen and not admin
            if ($dosenId) { // user is dosen and has Dosen record
                $pengajuanQuery->where('idDosen', $dosenId);
            } else { // user is dosen but has no Dosen record
                // Safety filter: if a user is a dosen but has no Dosen record, show none.
                $pengajuanQuery->whereRaw('1 = 0');
            }
        }

        // 4. --- Pass data to the view ---
        return view('dupak.dashboard', [
            'user' => $user,
            'dosenId' => $dosenId,
            'currentKum' => number_format($currentKum, 2),
            'goalKum' => number_format($goalKum, 2),
            'percent' => $percent,
            'remaining' => number_format($remaining, 2),
            'statusColor' => $statusColor,
            'jabatan_saat_ini' => $riwayat_jabatan_saat_ini ? $riwayat_jabatan_saat_ini : 'Belum Ada Riwayat Jabatan',
            'updatedAtFormatted' => $updatedAt,
            'pengajuan' => $pengajuanQuery->paginate(10),
        ]);
    }
}
