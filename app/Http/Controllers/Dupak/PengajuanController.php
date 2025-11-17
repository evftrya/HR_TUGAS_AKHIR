<?php

namespace App\Http\Controllers\Dupak;

use App\Http\Controllers\Controller;
use App\Models\Dupak\Pengajuan;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // If admin open this, then admin can see all submission which called pengajuan.
        // If user which is have to be dosen, then he/she can only his/her own submission.
        $user = Auth::user();

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

        // 3. Pass the Paginator object to the view
        return view('dupak.pengajuan.index', compact('pengajuan', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dupak.pengajuan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'period' => 'required|string',
            // Add other validation rules as needed
        ]);

        // Resolve dosen for current user
        // Note: Make sure Dosen model has the $connection set to 'sdm_tus'
        $dosen = Dosen::where('users_id', Auth::id())->first();

        if (! $dosen) {
            return redirect()->back()->with('error', 'Data Dosen tidak ditemukan untuk pengguna ini.');
        }

        // Create the pengajuan record
        $pengajuan = Pengajuan::create([
            'idDosen' => $dosen->id,
            'start' => now(),
            'end' => null,
            'TahunAjaranAjuanAwal' => $request->tahun_ajaran_awal,
            'TahunAjaranAjuanAkhir' => $request->tahun_ajaran_akhir,
            'semesterAjuan' => $request->semester,
            'status' => 'pending'
        ]);

        // Process each kegiatan type
        $this->processKegiatanDetails($pengajuan, $request, 'education');
        $this->processKegiatanDetails($pengajuan, $request, 'teaching');
        $this->processKegiatanDetails($pengajuan, $request, 'research');
        $this->processKegiatanDetails($pengajuan, $request, 'committee');

        return redirect()->route('dupak.pengajuan.index')
            ->with('success', 'Pengajuan DUPAK berhasil disimpan.');
    }

    /**
     * Process kegiatan details for different types of activities.
     */
    private function processKegiatanDetails($pengajuan, $request, $type)
    {
        if ($request->has($type . '_title') && $request->has($type . '_credit')) {
            $pengajuan->details()->create([
                'kegiatan_id' => 1, // This should be mapped to the correct kegiatan ID
                'angka_kredit' => $request->input($type . '_credit'),
                // Add other fields as needed
            ]);
        }
    }
}
