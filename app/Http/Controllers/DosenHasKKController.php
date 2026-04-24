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

            if ((! $cek_exist_dosen) || (! $cek_exist_sub_kk)) {
                throw new \Exception('Dosen atau Sub KK yang anda pilih sepertinya belum terdaftar, mohon dicek kembali.');
            }

            // $is_dosen_has_kk = Dosen::with('HasKK')->where('id', $request->dosen_id)->where('HasKK.is_active', 1)->first();
            $is_dosen_has_kk = Dosen::with('hasKK')
                ->where('id', $request->dosen_id)
                ->whereHas('hasKK', function ($q) {
                    $q->where('is_active', 1);
                })
                ->first();
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
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error_alert', $e->getMessage());
        }
    }

    public function validation(Request $request)
    {
        return $validated = $request->validate([
            'dosen_id' => ['required'],
            'sub_kk_id' => ['required'],
        ], [
            'required' => ':attribute wajib diisi.',
        ], [
            // optional: ganti nama attribute biar rapi
            'dosen_id' => 'Dosen',
            'sub_kk_id' => 'Sub Kelompok Keahlian',
        ]);
    }

    public function lepas_dosen($DosenHasKK_id = null)
    {

        try {

            if ($DosenHasKK_id == null) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian belum ada.');
            }

            $cek_exist_id = DosenHasKK::where('id', $DosenHasKK_id)->first();
            if (! $cek_exist_id) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian tidak terdaftar.');
            }
            // $validated = $this->validation($request);
            DB::beginTransaction();

            $cek_exist_id->is_active = 0;

            if ($cek_exist_id->save()) {
                DB::commit();

                return redirect()->back()->with('success', 'Berhasil melepaskan dosen dari Sub Kelompok Keahlian');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error_alert', $e->getMessage());
        }
    }

    public function struktur(Request $request)
    {
        $validated = $request->validate([
            'filter_date' => ['nullable', 'date'],
        ]);

        $bindings = [];
        $filter_date = null;
        if ($request->filter_date) {
            $filter_date = 'AND (a.tmt_selesai IS NULL OR a.tmt_selesai >= ?)';
            $bindings[] = $request->filter_date;
        } else {
            $filter_date = '';
        }

        $database = DB::select("

        SELECT
    a3.id AS fakultas_id,
    a3.kode AS fakultas_kode,
    a3.position_name AS fakultas_name,
    (
        SELECT
            CONCAT('[',
                IFNULL(GROUP_CONCAT(
                    JSON_OBJECT(
                        'kk_id', a1.id,
                        'kk_nama', a1.nama,
                        'kk_kode', a1.kode,
                        'kk_desc', a1.deskripsi,
                        'sub', (
                            SELECT
                                CONCAT('[',
                                    IFNULL(GROUP_CONCAT(
                                        JSON_OBJECT(
                                            'id_sub', b.id,
                                            'nama_sub', b.nama,
                                            'kode_sub', b.kode,
                                            'desc_sub', b.deskripsi,
                                            'dosens', (
                                                SELECT
                                                    CONCAT('[',
                                                        IFNULL(GROUP_CONCAT(
                                                            JSON_OBJECT(
                                                                'dosen_id', a6.dosen_id,
                                                                'dosen_name', b7.nama_lengkap
                                                            )
                                                        ), '')
                                                    , ']')
                                                FROM dosen_has_kk a6
                                                JOIN dosens b6 ON b6.id = a6.dosen_id
                                                JOIN users b7 ON b7.id = b6.users_id
                                                WHERE a6.sub_kk_id = b.id and a6.is_active= 1
                                            )
                                        )
                                    ), '')
                                , ']')
                            FROM ref_sub_kelompok_keahlians b
                            WHERE b.kk_id = a1.id
                        )
                    )
                ), '')
            , ']')
        FROM kelompok_keahlian a1
        WHERE a1.fakultas_id = a3.id
    ) AS result
FROM work_positions a3
WHERE a3.type_work_position = 'Fakultas';

        ");
        foreach ($database as $row) {
            // Cek jika result masih berupa string (bukan array/objek)
            if (is_string($row->result)) {
                $row->result = json_decode($row->result);
            }

            // Terkadang GROUP_CONCAT di dalam JSON_OBJECT juga menghasilkan string
            // Kita pastikan level di bawahnya juga ter-decode jika perlu
            if (isset($row->result) && is_array($row->result)) {
                foreach ($row->result as $kk) {
                    if (is_string($kk->sub)) {
                        $kk->sub = json_decode($kk->sub);
                    }
                    if (isset($kk->sub) && is_array($kk->sub)) {
                        foreach ($kk->sub as $sub) {
                            if (is_string($sub->dosens)) {
                                $sub->dosens = json_decode($sub->dosens);
                            }
                        }
                    }
                }
            }
        }

        // dd($database);

        return view('kelola_data.kelompok_keahlian.dosen-has-kk.struktur', compact('database', 'filter_date'));
    }

    public function table()
    {
        $data = DosenHasKK::with(['dosen.pegawai', 'subKK.KK.fakultas'])->get();

        // dD($data);
        return view('kelola_data.kelompok_keahlian.dosen-has-kk.table', compact('data'));
    }

    public function riwayat($id_user)
    {
        $dosen = Dosen::where('users_id', $id_user)->first();
        if(!$dosen){
            return redirect()->back()->with('error_alert', 'Dosen Tidak Ditemukan!.');
        }
        $user = (new ProfileController)->based_user_data($id_user);
        $history = DosenHasKK::with('subKK.KK.fakultas')->where('dosen_id', $dosen->id)->get()->sortByDesc('created_at');
        return view('kelola_data.pegawai.view.history.kelompok-keahlan', compact('user', 'history'));
    }
}
