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
        $validated['kode'] = strtoupper($validated['kode']);
        try {
            DB::beginTransaction();

            $save = RefResearchCoe::create($validated);
            if (! $save) {
                throw new \Exception('Gagal menyimpan data!.');
            }
            DB::commit();

            $route = redirect(route('manage.coe.ref-reserach.list'))->with('success', 'Data Research Berhasil ditambahkan!.');

            return $this->CekReview($route, '1QA1', 'MENAMBAHKAN RESEARCH GRUB COE');

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->handleRedirectBack()->withInput($request->all())->with('error_alert', $e->getMessage());
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

            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validation = $this->validation($id);
        $validated = $request->validate($validation[0], $validation[1], $validation[2]);
        $validated['kode'] = strtoupper($validated['kode']);
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

            return $this->handleRedirectBack()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function validation($id=null)
    {
        $id = $id==null?'':','.$id;
        return [
            [
                'kode' => [
                    'required',
                    'string',
                    'max:50',
                    'regex:/^[A-Za-z]+$/','unique:ref_research_coes,kode'.$id
                ],

                'nama' => [
                    'required',
                    'string',
                    'max:200',
                    'regex:/^[\pL\s]+$/u','unique:ref_research_coes,nama'.$id
                ],
            ],
            [
                'kode.required' => ':attribute wajib diisi',
                'kode.string' => ':attribute harus berupa teks',
                'kode.max' => ':attribute maksimal :max karakter',
                'kode.regex' => ':attribute hanya boleh berisi huruf tanpa spasi, angka, dan karakter khusus',

                'nama.required' => ':attribute wajib diisi',
                'nama.string' => ':attribute harus berupa teks',
                'nama.max' => ':attribute maksimal :max karakter',
                'nama.regex' => ':attribute hanya boleh berisi huruf dan spasi, tanpa angka dan karakter khusus',
                'unique' => ':attribute Sudah Terdaftar Sebelumnya!.'
            ],
            [
                'kode' => 'Singkatan Research Group',
                'nama' => 'Nama Research Group',
            ],
        ];
    }
}
