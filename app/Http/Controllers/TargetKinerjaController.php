<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetKinerja;
use App\Models\KinerjaSetting;
use Illuminate\Support\Facades\Redirect;

class TargetKinerjaController extends Controller
{
    public function laporan(Request $request)
    {
        $query = \App\Models\TargetKinerja::with(['pegawai' => function($q) {
            $q->with('dosen');
        }]);

        // Filter opsional
        if ($request->filled('status')) {
            $query->whereHas('pegawai', function($q) use ($request) {
                $q->wherePivot('status', $request->status);
            });
        }
        if ($request->filled('user_id')) {
            $query->whereHas('pegawai', function($q) use ($request) {
                $q->where('users.id', $request->user_id);
            });
        }
        if ($request->filled('target_id')) {
            $query->where('id', $request->target_id);
        }

        $targetKinerjaList = $query->get();

        // Untuk filter dropdown
        $allUsers = \App\Models\User::orderBy('nama_lengkap')->get();
        $allTargets = \App\Models\TargetKinerja::orderBy('nama')->get();

        return view('kelola_data.target_kinerja.laporan', compact('targetKinerjaList', 'allUsers', 'allTargets'));
    }
    public function index()
    {
        $items = TargetKinerja::orderBy('id', 'desc')->get();
        return view('kelola_data.target_kinerja.list', ['targetKinerja' => $items]);
    }

    public function create()
    {
        return view('kelola_data.target_kinerja.input');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'bobot' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['bobot'] = $data['bobot'] ?? 0;
        $data['is_active'] = $request->has('is_active') ? (bool)$data['is_active'] : true;

        TargetKinerja::create($data);

        return Redirect::route('manage.target-kinerja.list')->with('success', 'Target Kinerja dibuat');
    }

    public function show($id)
    {
        $item = TargetKinerja::findOrFail($id);
        return view('kelola_data.target_kinerja.view', ['targetKinerja' => $item]);
    }

    public function edit($id)
    {
        $item = TargetKinerja::findOrFail($id);
        return view('kelola_data.target_kinerja.edit', ['targetKinerja' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = TargetKinerja::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'bobot' => 'nullable|integer',
        ]);

        $data['bobot'] = $data['bobot'] ?? 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $item->update($data);

        return Redirect::route('manage.target-kinerja.list')->with('success', 'Target Kinerja diperbarui');
    }

    public function destroy($id)
    {
        $item = TargetKinerja::findOrFail($id);
        $item->delete();

        return Redirect::route('manage.target-kinerja.list')->with('success', 'Target Kinerja dihapus');
    }

    public function assign($id)
    {
        $targetKinerja = TargetKinerja::findOrFail($id);
        $pegawai = \App\Models\User::orderBy('nama_lengkap')->get();
        $assignedPegawai = $targetKinerja->pegawai;

        return view('kelola_data.target_kinerja.assign', compact('targetKinerja', 'pegawai', 'assignedPegawai'));
    }

    public function storeAssignment(Request $request, $id)
    {
        $targetKinerja = TargetKinerja::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
            'catatan' => 'nullable|string',
        ]);

        $pivotData = [
            'tanggal_mulai' => $data['tanggal_mulai'] ?? null,
            'tanggal_selesai' => $data['tanggal_selesai'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'catatan' => $data['catatan'] ?? null,
        ];

        $targetKinerja->pegawai()->attach($data['user_id'], $pivotData);

        return Redirect::route('manage.target-kinerja.assign', $id)->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function detachPegawai($id, $userId)
    {
        $targetKinerja = TargetKinerja::findOrFail($id);
        $targetKinerja->pegawai()->detach($userId);

        return Redirect::route('manage.target-kinerja.assign', $id)->with('success', 'Pegawai berhasil dihapus');
    }

    public function settings()
    {
        $settings = KinerjaSetting::all()->keyBy('key');
        return view('kelola_data.target_kinerja.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->all();

        // Remove CSRF token
        unset($data['_token']);

        foreach ($data as $key => $value) {
            if (strpos($key, '_type') !== false) {
                continue; // Skip type fields
            }

            $typeKey = $key . '_type';
            $type = $data[$typeKey] ?? 'string';
            $description = $data[$key . '_description'] ?? null;

            KinerjaSetting::set($key, $value, $type, $description);
        }

        return Redirect::route('manage.target-kinerja.settings')->with('success', 'Pengaturan berhasil disimpan');
    }
}
