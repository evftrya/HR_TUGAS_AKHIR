<?php

namespace App\Http\Controllers;

use App\Models\KelompokKeahlian;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelompokKeahlianController extends Controller
{


    public function index()
    {
        $query = DB::select("
            SELECT 
                m.id as fakultas_id, m.position_name as fakultas_name, m.kode as fakultas_code,
                a.id as kk_id, a.nama as kk_name, a.kode as kk_code,   a.deskripsi as kk_deskripsi,
                
                b.id as sub_kk_id, b.nama as sub_kk_name, b.kode as sub_kk_code, b.deskripsi as sub_kk_deskripsi
            FROM kelompok_keahlian a 
            JOIN work_positions m ON m.id = a.fakultas_id
            LEFT JOIN ref_sub_kelompok_keahlians b ON b.kk_id = a.id
        ");
        $registryData = collect($query)->groupBy('fakultas_id')->map(function ($items) {
            $first = $items->first();
            return [
                'id' => $first->fakultas_id,
                'nama_fakultas' => $first->fakultas_name,
                'kode_fakultas' => $first->fakultas_code,
                'kks' => $items->groupBy('kk_id')->map(function ($kkItems) {
                    $kkFirst = $kkItems->first();
                    return [
                        'id' => $kkFirst->kk_id,
                        'nama_kk' => $kkFirst->kk_name,
                        'kode_kk' => $kkFirst->kk_code,
                        'deskripsi' => $kkFirst->kk_deskripsi,
                        'subs' => $kkItems->whereNotNull('sub_kk_id')->map(function ($sub) {
                            return [
                                'id' => $sub->sub_kk_id,
                                'nama_sub_kk' => $sub->sub_kk_name,
                                'kode_sub_kk' => $sub->sub_kk_code,
                                'deskripsi_sub' => $sub->sub_kk_deskripsi,
                            ];
                        })->values()->all()
                    ];
                })->values()->all()
            ];
        })->values()->all();

        // Ambil data untuk dropdown select di form
        $fakultas = DB::table('work_positions')->get();

        // return view('nama_file_blade_anda', compact('registryData', 'fakultas'));
        return view('kelola_data.kelompok_keahlian.list', compact('registryData', 'fakultas'));
    }

    public function create()
    {
        return view('kelola_data.kelompok_keahlian.input');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kk' => 'required|string|max:255',
            'sub_kk' => 'nullable|string|max:255',
        ]);

        KelompokKeahlian::create($validated);

        return redirect()->route('manage.kelompok-keahlian.list')->with('success', 'Kelompok Keahlian berhasil ditambahkan');
    }

    public function show($id)
    {
        $kelompokKeahlian = KelompokKeahlian::with('dosen.pegawai')->findOrFail($id);

        // Ambil semua dosen yang belum tergabung di KK ini
        $allDosen = \App\Models\Dosen::with('pegawai')
            ->whereDoesntHave('kelompokKeahlian', function ($q) use ($id) {
                $q->where('kelompok_keahlian.id', $id);
            })->get();

        // Dosen nonaktif: opsional, misal dosen yang pernah tergabung lalu di-nonaktifkan (detach)
        // Jika ingin menampilkan dosen yang tidak lagi tergabung, perlu histori atau soft delete pada pivot
        // Untuk sementara, kosongkan saja jika belum ada logika nonaktif sebenarnya
        $nonaktifDosen = [];

        return view('kelola_data.kelompok_keahlian.view', compact('kelompokKeahlian', 'allDosen', 'nonaktifDosen'));
    }

    public function edit($id)
    {
        $kelompokKeahlian = KelompokKeahlian::findOrFail($id);
        return view('kelola_data.kelompok_keahlian.edit', compact('kelompokKeahlian'));
    }

    public function update(Request $request, $id)
    {
        $kelompokKeahlian = KelompokKeahlian::findOrFail($id);

        $validated = $request->validate([
            'nama_kk' => 'required|string|max:255',
            'sub_kk' => 'nullable|string|max:255',
        ]);

        $kelompokKeahlian->update($validated);

        return redirect()->route('manage.kelompok-keahlian.list')->with('success', 'Kelompok Keahlian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kelompokKeahlian = KelompokKeahlian::findOrFail($id);
        $kelompokKeahlian->delete();

        return redirect()->route('manage.kelompok-keahlian.list')->with('success', 'Kelompok Keahlian berhasil dihapus');
    }

    public function nonaktifkan(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        $kelompokKeahlian = KelompokKeahlian::findOrFail($id);
        $kelompokKeahlian->dosen()->detach($validated['dosen_id']);

        return redirect()->back()->with('success', 'Dosen berhasil dinonaktifkan dari kelompok keahlian');
    }

    public function assignDosen(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|array',
            'dosen_id.*' => 'exists:dosens,id',
        ]);

        $kelompokKeahlian = KelompokKeahlian::findOrFail($id);
        $kelompokKeahlian->dosen()->syncWithoutDetaching($validated['dosen_id']);

        return redirect()->back()->with('success', 'Dosen berhasil ditambahkan ke kelompok keahlian');
    }

    public function pegawaiList()
    {
        $dosen = Dosen::with('kelompokKeahlian', 'pegawai')->get();
        return view('kelola_data.kelompok_keahlian.pegawai_list', compact('dosen'));
    }
}
