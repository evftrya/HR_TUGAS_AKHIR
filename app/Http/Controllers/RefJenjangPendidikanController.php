<?php

namespace App\Http\Controllers;

use App\Models\RefJenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
        return view('kelola_data.jenjang-pendidikan.ref.new');
    }

    public function store(Request $request)
    {
        $validate = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_kode = RefJenjangPendidikan::where('jenjang_pendidikan', $request->jenjang_pendidikan)->first();
            if ($cek_kode) {
                throw new \Exception('Jenjang Pendidikan ini sudah terdaftar!.');
            }

            $request['jenjang_pendidikan'] = Str::upper($request->jenjang_pendidikan);
            $make = RefJenjangPendidikan::create($validate);
            if (!$make) {
                throw new \Exception('Terjadi masalah saat melakukan simpan data!.');
            }
            $route = Redirect(route('manage.jenjang-pendidikan.ref.list'))->with('success', 'Berhasil melakukan simpan data!.');
            DB::commit();
            return $route;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function edit()
    {
        if (request()->filled('id')) {
            request()->validate([
                'id' => 'string|exists:ref_jenjang_pendidikans,id'
            ]);
            $data = RefJenjangPendidikan::where('id', request('id'))->first();
            // Lanjutkan logika kamu di sini
            return view('kelola_data.jenjang-pendidikan.ref.edit', compact('data'));
        } else {
            return redirect()->back()->with('Data tidak ditemukan!.');
        }
    }

    public function update(Request $request)
    {
        // dd($request);
        if (!isset($request->id)) {
            return redirect()->back()->with('error_alert', 'Sepertinya terjadi masalah, silahkan lakukan kembali dalam beberapa detik!.');
        }

        $validate = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            $cek_kode = null;
            try {
                $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Jenjang Pendidikan ini tidak terdaftar!.');
            }
            // if (!$cek_kode) {
            //     throw new \Exception('Jenjang Pendidikan ini tidak terdaftar!.');
            // }
            $request['jenjang_pendidikan'] = Str::upper($request->jenjang_pendidikan);
            $update = $cek_kode->update($request->all());
            if (!$update) {
                throw new \Exception('Terjadi masalah saat melakukan update data!.');
            }
            $route = Redirect(route('manage.jenjang-pendidikan.ref.list'))->with('success', 'Berhasil melakukan update data!.');
            DB::commit();
            return $route;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function validation()
    {
        return [
            [
                'id' => 'nullable|string|max:100',
                'jenjang_pendidikan' => 'required|string|max:10',
                'tingkat'      => 'required|string|max:100',
                'urutan'       => 'required|numeric|min:1',
                'kode_gelar'   => 'required|string|max:20',
            ],
            [
                'required' => ':attribute wajib diisi.',
                'max'      => ':attribute maksimal :max karakter.',
                'numeric'  => ':attribute harus berupa angka.',
            ],
            [
                'jenjang_pendidikan' => 'Kode Jenjang Pendidikan',
                'tingkat'      => 'Tingkat',
                'urutan'       => 'Urutan',
                'kode_gelar'   => 'Kode Gelar',
            ]
        ];
    }
}
