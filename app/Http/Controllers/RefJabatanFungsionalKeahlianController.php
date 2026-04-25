<?php

namespace App\Http\Controllers;

use App\Models\RefJabatanFungsionalKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefJabatanFungsionalKeahlianController extends Controller
{
    public function list()
    {
        $data = RefJabatanFungsionalKeahlian::all()->sortBy('nama_jfk');
        $route = view('kelola_data.jfk.ref.list', compact('data'));
        return $this->CekReview($route, '1ZM3', 'MELIHAT DATA REFERENSI JFK', true);

    }

    public function store(Request $request)
    {
        $validate = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            try {
                $cek_kode = RefJabatanFungsionalKeahlian::findOrFail($request->id);
                if ($cek_kode) {
                    throw new \Exception('Gagal Menyimpan Data, Nama ini sudah terdaftar!.');
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $cek_kode = null;
            }
            $validate['nama_jfk'] = ucwords(strtolower($validate['nama_jfk']));

            $save = RefJabatanFungsionalKeahlian::create($validate);
            if (!$save) {
                throw new \Exception('Terjadi masalah saat menyimpan data!.');
            }
            DB::commit();
            $route = redirect(route('manage.jfk.ref.list'))->with('success', 'Berhasil Menambah Data!');
            // return $route;
            return $this->CekReview($route, '1ZM1', 'MENAMBAH DATA REFERENSI JFK');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_alert', $e->getMessage());

        }
    }

    public function edit()
    {
        return view('kelola_data.jfk.ref.edit');
    }

    public function update(Request $request, $id)
    {

        $validate = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_kode = null;
            try {
                $cek_kode = RefJabatanFungsionalKeahlian::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Master Data JFK ini tidak terdaftar!.');
            }

            $validate['nama_jfk'] = ucwords(strtolower($validate['nama_jfk']));
            if (!$cek_kode->update($validate)) {
                throw new \Exception('Gagal Menyimpan Data, coba beberapa saat lagi!.');
            }
            DB::commit();
            $route = redirect(route('manage.jfk.ref.list'))->with('success', 'Berhasil Menambah Data!');
            // return $route;
            return $this->CekReview($route, '1ZM2', 'MENGUBAH DATA REFERENSI JFK');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function validation()
    {
        return [
            [
                'nama_jfk' => 'required|string|max:200'
            ],
            [
                'required' => 'Wajib diisi'
            ],
            [
                'nama_jfk' => 'Nama Jabatan Fungsional Keahlian'
            ]
        ];
    }
}
