<?php

namespace App\Http\Controllers;

use App\Models\RefResearchCoe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RefResearchCoeController extends Controller
{
    public function list()
    {

        $today = Carbon::today();

        $data = RefResearchCoe::withCount([
            'coe',
            'coe as dosen_aktif_count' => function ($q) use ($today) {
                $q->join('dosen_has_c_o_e_s', 'coe.id', '=', 'dosen_has_c_o_e_s.coe_id')
                    ->where(function ($q2) use ($today) {
                        $q2->whereNull('dosen_has_c_o_e_s.tmt_selesai')
                            ->orWhereDate('dosen_has_c_o_e_s.tmt_selesai', '>=', $today);
                    })
                    ->selectRaw('count(distinct dosen_has_c_o_e_s.id)');
            },
        ])->get()->sortBy('nama');
        // dd($data);

        return view('kelola_data.coe.ref-research.list', compact('data'));
    }

    public function new()
    {
        $route = view('kelola_data.coe.ref-research.input');
        return $this->CekReview($route, '1QA2', 'MALIHAT LIST RESEARCH GRUB COE');

    }

    public function create(Request $request)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_exist_kode = RefResearchCoe::where('kode', $request->kode)->first();
            if ($cek_exist_kode) {
                throw new \Exception('Kode ini sudah terdaftar!.');
            }

            $save = RefResearchCoe::create($validated);
            if (! $save) {
                throw new \Exception('Gagal menyimpan data!.');
            }
            DB::commit();

            $route = redirect(route('manage.coe.ref-reserach.list'))->with('success', 'Data Research Berhasil ditambahkan!.');
        return $this->CekReview($route, '1QA1', 'MENAMBAHKAN RESEARCH GRUB COE');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function edit($id_ref)
    {
        // dd($id_ref);
        try {
            if ($id_ref == null) {
                throw new \Exception('Tidak ada research Rujukan!.');
            }
            $cek_exist_kode = null;
            try {
                $cek_exist_kode = RefResearchCoe::findOrFail($id_ref);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $f) {
                throw new \Exception('Research Group ini tidak terdaftar!.');
            }

            $data = $cek_exist_kode;

            $route = view('kelola_data.coe.ref-research.update', compact('data'));
        return $this->CekReview($route, '1QA2', 'MALIHAT LIST RESEARCH GRUB COE');

        } catch (\Exception $e) {

            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            $cek_exist_kode = null;
            try {
                $cek_exist_kode = RefResearchCoe::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $f) {
                throw new \Exception('Research Group ini tidak terdaftar!.');
            }

            $save = $cek_exist_kode->update($validated);
            if (! $save) {
                throw new \Exception('Gagal memperbarui data!.');
            }
            DB::commit();

            $route = redirect(route('manage.coe.ref-reserach.list'))->with('success', 'Data Research Berhasil diperbaharui!.');
        return $this->CekReview($route, '1QA3', 'MENGUBAH DATA RESEARCH GRUB COE');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function validation()
    {
        return [
            [
                'kode' => ['required', 'string', 'max:50'],
                'nama' => ['required', 'string', 'max:200'],
            ],
            [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus berupa teks',
                'max' => ':attribute maksimal :max karakter',
            ],
            [
                'kode' => 'Singkatan Research Group',
                'nama' => 'Nama Research Group',
            ],
        ];
    }
}
