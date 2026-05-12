<?php

namespace App\Http\Controllers;

use App\Models\RefJenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefJenjangPendidikanController extends Controller
{
    public function list()
    {
        $data = RefJenjangPendidikan::all()->sortBy('urutan');

        return view('kelola_data.jenjang-pendidikan.ref.list', compact('data'));
    }

    public function new()
    {
        $route = view('kelola_data.jenjang-pendidikan.ref.new');

        return $this->CekReview($route, '1FB3', 'MELIHAT LIST REF JENJANG PENDIDIKAN');
    }

    public function store(Request $request)
    {
        $validation = $this->validation();
        $validate = $request->validate($validation[0], $validation[1], $validation[2]);
        try {
            DB::beginTransaction();

            $cek_kode = RefJenjangPendidikan::where('jenjang_pendidikan', $request->jenjang_pendidikan)->first();
            if ($cek_kode) {
                throw new \Exception('Jenjang Pendidikan ini sudah terdaftar!.');
            }

            $request['jenjang_pendidikan'] = Str::upper($request->jenjang_pendidikan);
            $make = RefJenjangPendidikan::create($validate);
            if (! $make) {
                throw new \Exception('Terjadi masalah saat melakukan simpan data!.');
            }
            $route = Redirect(route('manage.jenjang-pendidikan.ref.list'))->with('success', 'Berhasil melakukan simpan data!.');
            DB::commit();

            return $this->CekReview($route, '1FB1', 'MENAMBAH REF JENJANG PENDIDIKAN');

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function edit()
    {
        if (request()->filled('id')) {
            request()->validate([
                'id' => 'string|exists:ref_jenjang_pendidikans,id',
            ]);
            $data = RefJenjangPendidikan::where('id', request('id'))->first();
            // Lanjutkan logika kamu di sini
            $route = view('kelola_data.jenjang-pendidikan.ref.edit', compact('data'));

            return $this->CekReview($route, '1FB3', 'MELIHAT LIST REF JENJANG PENDIDIKAN');

        } else {
            return $this->handleRedirectBack()->with('error_alert', 'Data tidak ditemukan!.');
        }
    }

    public function update(Request $request)
    {
        // dd($request);
        if (! isset($request->id)) {
            return $this->handleRedirectBack()->with('error_alert', 'Referensi tidak ditemukan!.');
        }

        $cek_kode = null;
        try {
            $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->handleRedirectBack()->with('error_alert', 'Jenjang Pendidikan ini tidak terdaftar!.');
        }
        $validation = $this->validation($request->id);
        $validated = $request->validate($validation[0], $validation[1], $validation[2]);

        try {
            DB::beginTransaction();

            $validated['jenjang_pendidikan'] = Str::upper($request->jenjang_pendidikan);
            $update = null;
            $update = $cek_kode->update($validated);
            // dd($update);
            $tes = RefJenjangPendidikan::findOrFail($request->id);
            // dd($tes);
            // dd($)
            if (! $update) {
                throw new \Exception('Terjadi masalah saat melakukan update data!.');
            }
            $route = redirect(route('manage.jenjang-pendidikan.ref.list'))->with('success', 'Berhasil melakukan ubah data!.');

            DB::commit();
            // return $route;
            return $this->CekReview($route, '1FB2', 'MENGUBAH REF JENJANG PENDIDIKAN');

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function validation($id = null)
    {
        $id = $id == null ? '' : ','.$id;

        return [
            [
                'id' => 'nullable|string|max:100',
                'jenjang_pendidikan' => 'required|string|max:10|unique:ref_jenjang_pendidikans,jenjang_pendidikan'.$id,
                'tingkat' => 'required|string|max:100|unique:ref_jenjang_pendidikans,tingkat'.$id,
                'urutan' => 'required|numeric|min:1',
                'kode_gelar' => 'required|string|max:20|unique:ref_jenjang_pendidikans,kode_gelar'.$id,
            ],
            [
                'required' => ':attribute wajib diisi.',
                'max' => ':attribute maksimal :max karakter.',
                'numeric' => ':attribute harus berupa angka.',
            ],
            [
                'jenjang_pendidikan' => 'Kode Jenjang Pendidikan',
                'tingkat' => 'Tingkat',
                'urutan' => 'Urutan',
                'kode_gelar' => 'Kode Gelar',
            ],
        ];
    }
}
