<?php

namespace App\Http\Controllers;

use App\Models\Coe;
use App\Models\RefResearchCoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoeController extends Controller
{
    public function index()
    {
        $data = Coe::with(['research'])
            ->withCount([
                'dosenCoe as active_dosen_coe' => function ($q) {
                    $q->where(function ($q) {
                        $q->where('tmt_selesai', '>=', today())
                            ->orWhereNull('tmt_selesai');
                    });
                },
            ])
            ->get()
            ->sortBy('nama_coe');

        // dd($data);
        // $data = Coe::with(['research','active_dosen_coe'])->get()->sortBy('nama_coe');
        return view('kelola_data.coe.list', compact('data'));
    }

    public function new()
    {
        $research = RefResearchCoe::all()->sortBy('nama');

        return view('kelola_data.coe.input', compact('research'));
    }

    public function create(Request $request)
    {
        // dd($this->validation());
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_exist_kode = Coe::where('kode_coe', $request->kode_coe)->first();
            if ($cek_exist_kode) {
                throw new \Exception('Kode ini sudah terdaftar!.');
            }
            $validated['kode_coe'] = strtoupper($validated['kode_coe']);
            $save = Coe::create($validated);
            if (! $save) {
                throw new \Exception('Gagal menyimpan data!.');
            }
            DB::commit();

            return redirect(route('manage.coe.index'))->with('success', 'Data CoE Berhasil ditambahkan!.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function show($id)
    {
        $coe = Coe::findOrFail($id);

        return view('coe.show', compact('coe'));
    }

    public function edit($id_coe)
    {
        try {
            if ($id_coe == null) {
                throw new \Exception('Tidak ada research Rujukan!.');
            }
            $cek_exist_kode = null;
            try {
                $cek_exist_kode = Coe::findOrFail($id_coe);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $f) {
                throw new \Exception('Research Group ini tidak terdaftar!.');
            }

            $coe = $cek_exist_kode;
                    $research = RefResearchCoe::all()->sortBy('nama');


            return view('kelola_data.coe.update', compact('coe', 'research'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id_coe)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            $cek_exist_kode = null;
            try {
                $cek_exist_kode = Coe::findOrFail($id_coe);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $f) {
                throw new \Exception('CoE ini tidak terdaftar!.');
            }
            $validated['kode_coe'] = strtoupper($validated['kode_coe']);

            $save = $cek_exist_kode->update($validated);
            if (! $save) {
                throw new \Exception('Gagal memperbarui data!.');
            }
            DB::commit();

            return redirect(route('manage.coe.index'))->with('success', 'Data CoE Berhasil diperbaharui!.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function validation()
    {
        return [
            [
                'kode_coe' => ['required', 'string', 'max:50'],
                'nama_coe' => ['required', 'string', 'max:200'],
                'ref_research_id' => ['required', 'string', 'max:100', 'exists:ref_research_coes,id'],
            ],
            [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus berupa teks',
                'max' => ':attribute maksimal :max karakter',
                'exist' => ':attribute Tidak Terdaftar',
            ],
            [
                'kode' => 'Singkatan Research Group',
                'nama' => 'Nama Research Group',
                'ref_research_id' => 'Research Group Pilihan',
            ],
        ];
    }
}
