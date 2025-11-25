<?php

namespace App\Http\Controllers;

use App\Models\KelompokKeahlian;
use App\Models\Dosen;
use Illuminate\Http\Request;

class KelompokKeahlianController extends Controller
{
    public function index()
    {
        $kelompokKeahlian = KelompokKeahlian::withCount('dosen')->get();
        return view('kelola_data.kelompok_keahlian.list', compact('kelompokKeahlian'));
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
            ->whereDoesntHave('kelompokKeahlian', function($q) use ($id) {
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
