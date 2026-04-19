<?php

namespace App\Http\Controllers;

use App\Models\RefJabatanFungsionalAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefJabatanFungsionalAkademikController extends Controller
{
    public function list()
    {
        $data = RefJabatanFungsionalAkademik::all()->sortBy('nama_jabatan');
        return view('kelola_data.jfa.ref.list', compact('data'));
    }

    public function new()
    {
        return view('kelola_data.jfa.ref.new');
    }

    public function store(Request $request)
    {
        $validate = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_kode = null;
            try {
                $cek_kode = RefJabatanFungsionalAkademik::findOrFail($request->kode);
                if ($cek_kode) {
                    throw new \Exception('Kode JFA ini sudah terdaftar');
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $cek_kode = null;
            }

            $validate['kode'] = strtoupper($validate['kode']);
            $save = RefJabatanFungsionalAkademik::create($validate);
            if (!$save) {
                throw new \Exception('Gagal Menyimpan Data, coba beberapa saat lagi!.');
            }
            DB::commit();
            $route = redirect(route('manage.jfa.ref.list'))->with('success', 'Berhasil Menambah Data!');
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
                'id' => 'string|exists:ref_jabatan_fungsional_akademiks,id'
            ]);
            $data = RefJabatanFungsionalAkademik::where('id', request('id'))->first();
            // Lanjutkan logika kamu di sini
            return view('kelola_data.jfa.ref.edit', compact('data'));
        } else {
            return redirect()->back()->with('error_alert', 'Data tidak ditemukan!.');
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_kode = null;
            try {
                $cek_kode = RefJabatanFungsionalAkademik::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Master Data JFA ini tidak terdaftar!.');
            }

            $validate['kode'] = strtoupper($validate['kode']);
            if (!$cek_kode->update($validate)) {
                throw new \Exception('Gagal Menyimpan Data, coba beberapa saat lagi!.');
            }
            DB::commit();
            $route = redirect(route('manage.jfa.ref.list'))->with('success', 'Berhasil Mengubah Data!');
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
                'kode'         => 'required|string|max:20',
                'nama_jabatan' => 'required|string|max:150',
                'kum'          => 'required|numeric|min:0',
            ],
            [
                'kode.required' => 'Singkatan tidak boleh kosong',
                'kum.numeric'   => 'Kum harus angka',
            ],
            [
                'kode' => 'Singkatan Jabatan',
                'nama_jabatan' => 'Nama Jabatan',
                'kum' => 'Minimal KUM'
            ]
        ];
    }
}
