<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\KelompokKeahlian;
use App\Models\RefSubKelompokKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefSubKelompokKeahlianController extends Controller
{
    public function index(){
        $sub_kk = RefSubKelompokKeahlian::withCount('dosenDipetakan')->with('KK')->get();
        // dd($sub_kk[0],$sub_kk[1]);
        return view('kelola_data.kelompok_keahlian.sub.list',compact('sub_kk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            $cek_exist_code = RefSubKelompokKeahlian::where('kode', $request->kode)->first();
            $cek_exist_kk = KelompokKeahlian::where('id', $request->kk_id)->first();

            if ($cek_exist_code) {
                throw new \Exception('Kode Sub Kelompok Keahlian ini sudah terdaftar, mohon coba yang lain!.');
            }

            if (! $cek_exist_kk) {
                throw new \Exception('Kelompok Keahlian tidak terdaftar di sistem, mohon coba yang lain!.');
            }

            $save = RefSubKelompokKeahlian::create($validated);
            if (! $save) {
                throw new \Exception('Terjadi masalah saat menyimpan data, mohon coba lagi dalam beberapa saat!.');
            }
            DB::commit();

            $route = ($this->handleRedirectBack())->with('success', 'Sub Kelompok Keahlian berhasil ditambahkan');
        return $this->CekReview($route, '1D3', 'MANAMBAH DATA SUB KELOMPOK KEAHLIAN', true);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error_alert' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            try {
                $cek_sub_kk = RefSubKelompokKeahlian::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Kode Sub Kelompok Keahlian ini tidak terdaftar!.');
            }
            $cek_exist_kk = KelompokKeahlian::where('id', $request->kk_id)->first();

            if (! $cek_exist_kk) {
                throw new \Exception('Kelompok Keahlian tidak terdaftar di sistem, mohon coba yang lain!.');
            }

            $save = $cek_sub_kk->update($validated);
            if (! $save) {
                throw new \Exception('Terjadi masalah saat menyimpan data, mohon coba lagi dalam beberapa saat!.');
            }
            DB::commit();

            return ($this->handleRedirectBack())->with('success', 'Sub Kelompok Keahlian berhasil diperbarui!.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error_alert' => $e->getMessage()]);
        }
    }

    public function validation()
    {
        return [
            [
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|max:50|unique:ref_sub_kelompok_keahlians,kode',
                'deskripsi' => 'required|string|max:255',
                'kk_id' => 'required|string|max:100',
            ],
            [
                '*.required' => ':attribute wajib diisi!',
                '*.unique' => ':attribute sudah terdaftar, silahkan coba yang lain!',
            ],
            [
                'nama' => 'Nama Sub Kelompok Keahlian',
                'kode' => 'Singkatan Sub Kelompok Keahlian',
                'kk_id' => 'Kelompok Keahlian Sub',
                'deskripsi' => 'Deskripsi Sub Kelompok Keahlian',
            ],
        ];
    }
}
