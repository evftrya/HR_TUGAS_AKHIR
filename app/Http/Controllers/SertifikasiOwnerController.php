<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\sertifikasi_owner;
use App\Models\SertifikasiDosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SertifikasiOwnerController extends Controller
{
    public function create(Request $request, $from = false)
    {
        // dd($request->all(),$request);
        try {
            DB::beginTransaction();

            $validated = $this->validation($request);


            $cek_dosen_exist = Dosen::where('id', $request->dosen_id)->first();
            $cek_sertifikasi_exist = SertifikasiDosen::where('id', $request->sertifikasi_id)->first();
            // dd($cek_dosen_exist, $cek_sertifikasi_exist);
            if ($cek_dosen_exist  && $cek_sertifikasi_exist) {
                $sertifikasi_owner_result = sertifikasi_owner::create($validated);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil memetakan owner ke sertifikasi',
                    'success' => $sertifikasi_owner_result
                ], 200);
            } else {
                throw new \Exception('Dosen atau Sertifikasi ini tidak terdaftar');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menautkan dosen ke sertifikasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function validation(Request $request)
    {
        return $validated = $request->validate($this->rules(), $this->detil1(), $this->detil2());
    }
    public function rules()
    {
        return [
            'dosen_id'          => ['required'],
            'sertifikasi_id'     => ['required'],
        ];
    }

    public function detil1()
    {
        return [
            'required'              => ':attribute wajib diisi.',
        ];
    }

    public function detil2()
    {
        return [
            'required'              => ':attribute wajib diisi.',
        ];
    }
}
