<?php

namespace App\Http\Controllers;

use App\Models\StudiLanjut;
use App\Models\User;
use Illuminate\Http\Request;

class StudiLanjutController extends Controller
{
    public function index()
    {
        $studiLanjut = StudiLanjut::with('user')->get();
        return view('kelola_data.studi_lanjut.list', compact('studiLanjut'));
    }

    public function create()
    {
        $pegawai = User::where('is_active', 1)->get();
        return view('kelola_data.studi_lanjut.input', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required|uuid|exists:users,id',
            'jenjang' => 'required|in:S2,S3',
            'program_studi' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'negara' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'status' => 'required|in:Sedang Berjalan,Selesai,Cuti',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        StudiLanjut::create($validated);

        return redirect()->route('manage.studi-lanjut.list')->with('success', 'Data studi lanjut berhasil ditambahkan');
    }

    public function show($id)
    {
        $studiLanjut = StudiLanjut::with('user')->findOrFail($id);
        return view('kelola_data.studi_lanjut.view', compact('studiLanjut'));
    }

    public function edit($id)
    {
        $studiLanjut = StudiLanjut::findOrFail($id);
        $pegawai = User::where('is_active', 1)->get();
        return view('kelola_data.studi_lanjut.edit', compact('studiLanjut', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $studiLanjut = StudiLanjut::findOrFail($id);

        $validated = $request->validate([
            'users_id' => 'required|uuid|exists:users,id',
            'jenjang' => 'required|in:S2,S3',
            'program_studi' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'negara' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'status' => 'required|in:Sedang Berjalan,Selesai,Cuti',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $studiLanjut->update($validated);

        return redirect()->route('manage.studi-lanjut.list')->with('success', 'Data studi lanjut berhasil diperbarui');
    }

    public function destroy($id)
    {
        $studiLanjut = StudiLanjut::findOrFail($id);
        $studiLanjut->delete();

        return redirect()->route('manage.studi-lanjut.list')->with('success', 'Data studi lanjut berhasil dihapus');
    }
}
