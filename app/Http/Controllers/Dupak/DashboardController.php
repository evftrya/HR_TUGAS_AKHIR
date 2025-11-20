<?php

namespace App\Http\Controllers\Dupak;

use App\Http\Controllers\Controller;
use App\Models\Dupak\Pengajuan;
use App\Models\Dosen; // Assuming your user model is Dosen, or simply Auth::user()
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Need to import Carbon for date formatting
use PHPUnit\Event\TestSuite\Loaded;

class DashboardController extends Controller
{
    /**
     * Display the DUPAK dashboard with necessary data.
     */
    public function index()
    {
        $user = Auth::user();

        // get all  pengajuan list dari db dupak regardless user id
        // $pengajuan = Pengajuan::all();
        // dd($pengajuan);

        // --- KUM Calculation Logic (Moved from the View) ---
        $currentKum = $user->kum;
        $goalKum = $user->kum_goal ?? 200;

        $percent = $goalKum > 0 ? min(100, ($currentKum / $goalKum) * 100) : 0;
        $remaining = max(0, $goalKum - $currentKum);

        // Determine status color (Tailwind classes)
        if ($percent >= 100) {
            $statusColor = 'bg-green-600';
        } elseif ($percent >= 60) {
            $statusColor = 'bg-yellow-500';
        } else {
            $statusColor = 'bg-indigo-600';
        }

        // Format the last updated time (using Carbon)
        $updatedAt = $user->kum_updated_at
            ? Carbon::parse($user->kum_updated_at)->diffForHumans()
            : null;

        // --- Admin/Validator Data ---
        $adminData = [];

        // ! get user from dosen table and get its name from username
        $dosen = Dosen::where('users_id', $user->id)->first();
        
        // ! get dosenId from dosen table where users_id = user id
        $dosenId = $dosen->id;


        if ($user->is_admin) {
            $pengajuan = Pengajuan::all();
        } else if ($user->is_dosen) {
            $pengajuan = Pengajuan::where('idDosen', $user->id);
        }


        // 1. Define the base query: fetch all submissions and eager load the cross-DB relationship ('dosen')
        $pengajuanQuery = Pengajuan::with('dosen') // Eager load the Dosen
            ->orderBy('id', 'desc');

        // 2. Execute the query and paginate the results
        $pengajuan = $pengajuanQuery;

        // dd($dosenId);

        // --- Pass all calculated and fetched data to the view ---
        return view('dupak.dashboard', array_merge([
            'user' => $user,
            'currentKum' => $currentKum,
            'goalKum' => $goalKum,
            'percent' => $percent,
            'remaining' => $remaining,
            'statusColor' => $statusColor,
            'updatedAtFormatted' => $updatedAt,
            'pengajuan' => $pengajuan,
            'adminData' => $adminData,
            'dosenId' => $dosenId,
        ], $adminData ?? ""));
    }
}
