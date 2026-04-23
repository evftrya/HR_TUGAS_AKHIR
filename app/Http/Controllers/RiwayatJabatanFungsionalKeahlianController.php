<?php

namespace App\Http\Controllers;

use App\Models\RefJabatanFungsionalKeahlian;
use App\Models\RiwayatJabatanFungsionalKeahlian;
use App\Models\SK;
use App\Models\Tpa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatJabatanFungsionalKeahlianController extends Controller
{
    public function index()
    {
        $jfks = riwayatJabatanFungsionalKeahlian::with('data_jfk', 'data_tpa', 'sk_ypt')->get();
        // dd($jfks);

        return view('kelola_data.jfk.list', compact('jfks'));
    }

    public function new()
    {
        $jfks = RefJabatanFungsionalKeahlian::all()->sortBy('nama_jfk')->values();
        $tpas = Tpa::with('pegawai')->get()->sortBy('pegawai.nama_lengkap')->values();
        $sk_ypts = SK::all()->sortBy('nomor_sk')->values();

        return view('kelola_data.jfk.input', compact('jfks', 'tpas', 'sk_ypts'));
    }

    public function update($id_jfk)
    {
        try {

            $jfk_data = null;

            try {
                $jfk_data = RiwayatJabatanFungsionalKeahlian::findOrFail($id_jfk);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Riwayat Jabatan Fungsional Keahlian (JFK) ini tidak terdaftar!.');
            }

            $jfks = RefJabatanFungsionalKeahlian::all()->sortBy('nama_jfk')->values();
            $tpas = Tpa::with('pegawai')->get()->sortBy('pegawai.nama_lengkap')->values();
            $sk_ypts = SK::all()->sortBy('nomor_sk')->values();

            return view('kelola_data.jfk.update', compact('jfk_data', 'jfks', 'tpas', 'sk_ypts'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);

        // DD('MASUK');

        // DD(isset($validated['sk_llkdikti_id']));
        DB::beginTransaction();
        // // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {

            // dd($isset_ypt);
            if (isset($validated['sk_pengakuan_ypt_id']) || isset($validated['no_sk_ypt'])) {
                if ($validated['no_sk_ypt'] != null) {
                    $validated['sk_pengakuan_ypt_id'] = null;
                }
                if ((! isset($validated['sk_pengakuan_ypt_id']))) {
                    // dd('masuk');

                    try {
                        $validated['no_sk'] = $validated['no_sk_ypt'];
                        $validated['tipe_sk'] = 'Pengakuan YPT';
                        // DB::commit();

                        $validated['users_id'] = Tpa::find($validated['tpa_id'])->users_id;
                        $validated['keterangan'] = 'Jabatan Fungsional Pegawai';
                        $validated['keperluan'] = 'JFK';

                        $sk = SK::create($validated);
                        $validated['sk_pengakuan_ypt_id'] = $sk->id;
                    } catch (\Exception $e) {
                        // DB::rollBack();

                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal membuat SK LLDIKTI',
                            'error' => $e->getMessage(),
                        ], 500);
                    }
                }
            } else {
                $validated['sk_pengakuan_ypt_id'] = null;
            }

            $old_jfk = RiwayatJabatanFungsionalKeahlian::where('tpa_id', $validated['tpa_id'])
                ->whereNull('tmt_selesai')
                ->first();
            $oldesst = $old_jfk;
            $old_jfk?->update(['tmt_selesai' => now()]);
            // dd($old_jfk);
            $new = riwayatJabatanFungsionalKeahlian::create($validated);



            DB::commit();
            dd($old_jfk, $new);
            return redirect(route('manage.jfk.list'))->with('success', 'JFK berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat JFK',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function isi_sk_ypt(Request $request, $id_jfk)
    {
        try {

            // $id_user = SK::with("user_data")->where('id', $id_sk)->first();
            $sk_ypt = (new SKController)->new($request, 'YPT', 'fromRiwayatJabatanFungsionalKeahlian');

            $jfk_update = null;
            try {
                $jfk_update = RiwayatJabatanFungsionalKeahlian::findOrFail($id_jfk);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Riwayat Jabatan Fungsional Keahlian (JFK) ini tidak terdaftar!.');
            }

            $jfk_update?->update(['sk_pengakuan_ypt_id' => $sk_ypt]);

            return redirect()->back()->with('success', 'Surat Keputusan Pengakuan YPT Untuk Jabatan Fungsional Keahlian karyawan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function update_data(Request $request, $id_jfk)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);

        // DD('MASUK');

        // DD(isset($validated['sk_llkdikti_id']));
        DB::beginTransaction();
        // // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {

            // dd($isset_ypt);
            if (isset($validated['sk_pengakuan_ypt_id']) || isset($validated['no_sk_ypt'])) {
                if ($validated['no_sk_ypt'] != null) {
                    $validated['sk_pengakuan_ypt_id'] = null;
                }
                if ((! isset($validated['sk_pengakuan_ypt_id']))) {
                    // dd('masuk');

                    try {
                        $validated['no_sk'] = $validated['no_sk_ypt'];
                        $validated['tipe_sk'] = 'Pengakuan YPT';
                        // DB::commit();

                        $validated['users_id'] = Tpa::find($validated['tpa_id'])->users_id;
                        $validated['keterangan'] = 'Jabatan Fungsional Pegawai';
                        $validated['keperluan'] = 'JFK';

                        $sk = SK::create($validated);
                        $validated['sk_pengakuan_ypt_id'] = $sk->id;
                    } catch (\Exception $e) {
                        // DB::rollBack();

                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal membuat SK LLDIKTI',
                            'error' => $e->getMessage(),
                        ], 500);
                    }
                }
            } else {
                $validated['sk_pengakuan_ypt_id'] = null;
            }

            $jfk_update = null;
            try {
                $jfk_update = RiwayatJabatanFungsionalKeahlian::findOrFail($id_jfk);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Riwayat Jabatan Fungsional Keahlian (JFK) ini tidak terdaftar!.');
            }
            $jfk_update->update($validated);

            DB::commit();

            return redirect(route('manage.jfk.list'))->with('success', 'JFK berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat JFK',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function validation()
    {
        return [
            [
                // Dosen & JFA
                'tpa_id'      => ['required'],
                'ref_jfk_id'    => ['required'],
                'tmt_mulai'     => ['required', 'date'],
                'tmt_selesai'     => ['nullable', 'date'],

                'sk_pengakuan_ypt_id' => ['nullable'],

                'file_sk_ypt'   => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg'],
                'no_sk_ypt'     => ['nullable', 'string', 'max:50', 'required_with:file_sk_ypt',],

            ],
            [

                'required' => ':attribute wajib diisi.',
                'date'     => ':attribute harus berupa tanggal yang valid.',

                'required_without'     => ':attribute wajib diisi jika :values tidak ada.',
                'required_without_all' => ':attribute wajib diisi jika :values tidak ada semuanya.',

            ],
            [

                'sk_pengakuan_ypt_id'   => 'SK YPT JKF (Entry Level - TPA)',
                'file_sk_ypt'           => 'file SK YPT JKF (Entry Level - TPA)',
                'no_sk_ypt'             => 'Nomor SK YPT JKF (Entry Level - TPA)',
                'tmt_mulai'           => 'Terakui Mulai Tanggal JKF (Entry Level - TPA)',
                'tmt_selesai'           => 'Selesai Pada Tanggal JKF (Entry Level - TPA)',
            ]
        ];
    }
}
