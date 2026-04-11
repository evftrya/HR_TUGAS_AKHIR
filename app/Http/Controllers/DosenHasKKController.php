<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\DosenHasKK;
use App\Models\RefSubKelompokKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenHasKKController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $this->validation($request);
            DB::beginTransaction();

            $cek_exist_dosen = Dosen::where('id', $request->dosen_id)->first();
            $cek_exist_sub_kk = RefSubKelompokKeahlian::where('id', $request->sub_kk_id)->first();


            if ((!$cek_exist_dosen) || (!$cek_exist_sub_kk)) {
                throw new \Exception('Dosen atau Sub KK yang anda pilih sepertinya belum terdaftar, mohon dicek kembali.');
            }

            $is_dosen_has_kk = Dosen::with('HasKK')->where('id', $request->dosen_id)->first();
            // dd($is_dosen_has_kk);
            // dd($is_dosen_has_kk);
            if ($is_dosen_has_kk) {
                throw new \Exception('Dosen sudah terdaftar di kelompok keahlian mohon nonaktifkan terlebih dahulu.');
            }

            $validated['is_active'] = 1;
            $create = DosenHasKK::create($validated);
            if ($create) {
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil menambahkan dosen ke Sub Kelompok Keahlian');
            };
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_alert', $e->getMessage());
        }
    }

    public function validation(Request $request)
    {
        return $validated = $request->validate([
            'dosen_id'   => ['required'],
            'sub_kk_id' => ['required'],
        ], [
            'required' => ':attribute wajib diisi.',
        ], [
            // optional: ganti nama attribute biar rapi
            'dosen_id' => 'Dosen',
            'sub_kk_id'   => 'Sub Kelompok Keahlian',
        ]);
    }

    public function lepas_dosen($DosenHasKK_id = null)
    {

        try {

            if ($DosenHasKK_id == null) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian belum ada.');
            }

            $cek_exist_id = DosenHasKK::where('id', $DosenHasKK_id)->first();
            if (!$cek_exist_id) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian tidak terdaftar.');
            }
            // $validated = $this->validation($request);
            DB::beginTransaction();

            $cek_exist_id->is_active = 0;
            
            if ($cek_exist_id->save()) {
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil melepaskan dosen dari Sub Kelompok Keahlian');
            };
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error_alert', $e->getMessage());
        }
    }
}
