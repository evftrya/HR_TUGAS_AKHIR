<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\RefJabatanFungsionalAkademik;
use App\Models\RiwayatJabatanFungsionalAkademik;
use App\Models\SK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatJabatanFungsionalAkademikController extends Controller
{
    public function index()
    {
        $jfas = riwayatJabatanFungsionalAkademik::with(['jfa', 'dosen.pegawai', 'sk_dikti', 'sk_ypt'])->get();

        // dd($jfas);
        $route = view('kelola_data.jfa.list', compact('jfas'));
        return $this->CekReview($route, '1O4', 'MELIHAT LIST DATA ENTRY LEVEL- DOSEN', true);

    }

    public function new()
    {
        $dosens = Dosen::with('pegawai')
            ->get()
            ->sortBy('pegawai.nama_lengkap')
            ->values(); // reset index
        // dd($dosens);

        $jfas = RefJabatanFungsionalAkademik::all()->sortBy('nama_jabatan')->values();
        $sk_diktis = SK::Sk_Dikti();
        $sk_ypts = SK::Sk_Ypt();

        return view('kelola_data.jfa.input', compact('dosens', 'jfas', 'sk_diktis', 'sk_ypts'));

    }

    public function store_data(Request $request)
    {
        // DD($request);
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        // dd($validated);
        try {
            DB::beginTransaction();
            $cek_exist = RiwayatJabatanFungsionalAkademik::where('dosen_id', $request->dosen_id)->where('ref_jfa_id', $request->ref_jfa_id)->first();
            if ($cek_exist) {
                throw new \Exception('Jabatan Fungsional Dosen ini dengan Jabatan ini sudah terdaftar!.');
            }

            if ($validated['no_sk_lldikti'] != null) {
                $validated['sk_llkdikti_id'] = null;
            }

            if ($validated['sk_llkdikti_id'] == null) {
                $save_sk_llkdikti = [];
                $save_sk_llkdikti['tipe_sk'] = 'LLDIKTI';
                $save_sk_llkdikti['keperluan'] = 'Jabatan Fungsional Akademik ';
                $save_sk_llkdikti['file_sk'] = $request->file('file_sk_lldikti');
                $save_sk_llkdikti['no_sk'] = $request->no_sk_lldikti;
                $save_sk_llkdikti['keterangan'] = $request->keterangan_sk_lldikti;
                $save_sk_llkdikti['tipe_dokumen'] = $request->tipe_dokumen_sk_lldikti;
                $save_sk_llkdikti['tmt_mulai'] = $request->tmt_mulai;
                $save_sk_llkdikti['tmt_selesai'] = $request->tmt_selesai;
                // dd($save_sk_llkdikti);
                $response = (new SKController)->new(new Request($save_sk_llkdikti), false, false);
                $sk_data = $response->getData();
                // dd($sk_data);

                if ($response->getStatusCode() != 200) {
                    throw new \Exception('Gagal save SK DIKTI: '.$sk_data->error);
                }
                $sk = $sk_data->data;
                $validated['sk_llkdikti_id'] = $sk->id;
            }

            if (($validated['file_sk_ypt'] != null || $validated['no_sk_ypt'] != null) || $validated['sk_pengakuan_ypt_id'] != null) {
                if ($validated['no_sk_ypt'] != null) {
                    $validated['sk_pengakuan_ypt_id'] = null;
                }
                if ($validated['sk_pengakuan_ypt_id'] == null) {
                    $save_sk_ypt = [];
                    $save_sk_ypt['tipe_sk'] = 'Pengakuan YPT';
                    $save_sk_ypt['keperluan'] = 'Jabatan Fungsional Akademik ';
                    $save_sk_ypt['file_sk'] = $request->file('file_sk_ypt');
                    $save_sk_ypt['no_sk'] = $request->no_sk_ypt;

                    $save_sk_ypt['keterangan'] = $request->keterangan_sk_ypt;
                    $save_sk_ypt['tipe_dokumen'] = $request->tipe_dokumen_sk_ypt;
                    $save_sk_ypt['tmt_mulai'] = $request->tmt_mulai;
                    $save_sk_ypt['tmt_selesai'] = $request->tmt_selesai;
                    // dd($validated);
                    $response = (new SKController)->new(new Request($save_sk_ypt), false, false);
                    $sk_data = $response->getData();
                    // dd($sk_data);

                    if ($response->getStatusCode() != 200) {
                        throw new \Exception('Gagal save SK YPT: '.$sk_data->error);
                    }
                    $sk = $sk_data->data;
                    $validated['sk_pengakuan_ypt_id'] = $sk->id;
                }
            }

            $save = RiwayatJabatanFungsionalAkademik::create($validated);
            if (! $save) {

                throw new \Exception('Gagal menyimpan data!.');
            }
            DB::commit();

            $route = redirect(route('manage.jfa.list'))->with('success', 'Berhasil menyimpan data!.');
        return $this->CekReview($route, '1O1', 'MENAMBAH DATA ENTRY LEVEL- DOSEN');


        } catch (\Exception $e) {
            DB::rollBack();

            return ($this->handleRedirectBack())->withInput($request->all())->with('error_alert', $e->getMessage());
        }

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Dosen & JFA
            'dosen_id' => ['required'],
            'ref_jfa_id' => ['required'],
            'tmt_mulai' => ['required', 'date'],

            /* ===============================
            VALIDASI SK LLKDIKTI
            =============================== */
            // Jika pilih existing: harus ada sk_llkdikti_id
            'sk_llkdikti_id' => ['nullable', 'required_without_all:file_sk_dikti,no_sk_dikti'],

            // Jika input baru: file & nomor wajib bila tidak memilih existing
            'file_sk_dikti' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'required_without:sk_llkdikti_id'],
            'no_sk_dikti' => ['nullable', 'string', 'max:50', 'required_without:sk_llkdikti_id', 'required_with:file_sk_dikti'],

            /* ===============================
            VALIDASI SK YPT
            (Boleh kosong semua)
            =============================== */
            'sk_pengakuan_ypt_id' => ['nullable'],

            'file_sk_ypt' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg'],
            'no_sk_ypt' => ['nullable', 'string', 'max:50', 'required_with:file_sk_ypt'],

        ], [

            'required' => ':attribute wajib diisi.',
            'date' => ':attribute harus berupa tanggal yang valid.',

            'required_without' => ':attribute wajib diisi jika :values tidak ada.',
            'required_without_all' => ':attribute wajib diisi jika :values tidak ada semuanya.',

        ], [
            // rename attributes biar rapi
            'sk_llkdikti_id' => 'SK LLKDIKTI',
            'file_sk_dikti' => 'file SK LLKDIKTI',
            'no_sk_dikti' => 'Nomor SK LLKDIKTI',

            'sk_pengakuan_ypt_id' => 'SK YPT',
            'file_sk_ypt' => 'file SK YPT',
            'no_sk_ypt' => 'Nomor SK YPT',
        ]);

        // DD('MASUK');

        // DD(isset($validated['sk_llkdikti_id']));
        DB::beginTransaction();
        // // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {

            if ($validated['no_sk_dikti'] != null) {
                $validated['sk_llkdikti_id'] = null;
            }
            if ((! isset($validated['sk_llkdikti_id']))) {
                // dd('masuk');

                try {
                    $validated['no_sk'] = $validated['no_sk_dikti'];
                    $validated['tipe_sk'] = 'LLDIKTI';
                    // DB::commit();

                    $validated['users_id'] = Dosen::find($validated['dosen_id'])->users_id;
                    $validated['keterangan'] = 'Jabatan Fungsional Pegawai';
                    $validated['keperluan'] = 'JFP';

                    $sk = SK::create($validated);
                    $validated['sk_llkdikti_id'] = $sk->id;
                } catch (\Exception $e) {
                    // DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat SK LLDIKTI',
                        'error' => $e->getMessage(),
                    ], 500);
                }
            }
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

                        $validated['users_id'] = Dosen::find($validated['dosen_id'])->users_id;
                        $validated['keterangan'] = 'Jabatan Fungsional Pegawai';
                        $validated['keperluan'] = 'JFA';

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

            // if(!isset($validated['sk_pengakuan_ypt_id'])){

            // }
            // dd($validated['sk_pengakuan_ypt_id']);

            $old_jfa = riwayatJabatanFungsionalAkademik::where('dosen_id', $validated['dosen_id'])
                ->whereNull('tmt_selesai')
                ->first();
            $oldesst = $old_jfa;
            $old_jfa?->update(['tmt_selesai' => now()]);
            // dd($old_jfa);
            riwayatJabatanFungsionalAkademik::create($validated);

            DB::commit();

            // dD($old_jfa,$oldesst);
            // dd('ypt',$validated['sk_pengakuan_ypt_id'],'dikti',$validated['sk_llkdikti_id']);
            // DD('DONE');
            // dd('done');
            $route = redirect(route('manage.jfa.list'))->with('success', 'JFA berhasil dibuat.');
            return $this->CekReview($route, '1O1', 'MENAMBAH DATA ENTRY LEVEL- DOSEN');

        } catch (\Exception $e) {
            DB::rollBack();
            return ($this->handleRedirectBack())->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function update($id_jfa)
    {
        $jfa_data = riwayatJabatanFungsionalAkademik::find($id_jfa);
        // dd($jfa_data->dosen->pegawai);

        $dosens = Dosen::with('pegawai')
            ->get()
            ->sortBy('pegawai.nama_lengkap')
            ->values(); // reset index
        // dd($dosens);

        $jfas = refJabatanFungsionalAkademik::all()->sortBy('nama_jabatan')->values();
        $sk_diktis = SK::Sk_Dikti();
        $sk_ypts = SK::Sk_Ypt();

        return view('kelola_data.jfa.update', compact('jfa_data', 'dosens', 'jfas', 'sk_diktis', 'sk_ypts'));
    }

    public function update_data(Request $request, $id_jfa)
    {
        $validated = $request->validate([
            // Dosen & JFA
            'dosen_id' => ['required'],
            'ref_jfa_id' => ['required'],
            'tmt_mulai' => ['required', 'date'],

            /* ===============================
            VALIDASI SK LLKDIKTI
            =============================== */
            // Jika pilih existing: harus ada sk_llkdikti_id
            'sk_llkdikti_id' => ['nullable', 'required_without_all:file_sk_dikti,no_sk_dikti'],

            // Jika input baru: file & nomor wajib bila tidak memilih existing
            'file_sk_dikti' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'required_without:sk_llkdikti_id'],
            'no_sk_dikti' => ['nullable', 'string', 'max:50', 'required_without:sk_llkdikti_id', 'required_with:file_sk_dikti'],

            /* ===============================
            VALIDASI SK YPT
            (Boleh kosong semua)
            =============================== */
            'sk_pengakuan_ypt_id' => ['nullable'],

            'file_sk_ypt' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg'],
            'no_sk_ypt' => ['nullable', 'string', 'max:50', 'required_with:file_sk_ypt'],

        ], [

            'required' => ':attribute wajib diisi.',
            'date' => ':attribute harus berupa tanggal yang valid.',

            'required_without' => ':attribute wajib diisi jika :values tidak ada.',
            'required_without_all' => ':attribute wajib diisi jika :values tidak ada semuanya.',

        ], [
            // rename attributes biar rapi
            'sk_llkdikti_id' => 'SK LLKDIKTI',
            'file_sk_dikti' => 'file SK LLKDIKTI',
            'no_sk_dikti' => 'Nomor SK LLKDIKTI',

            'sk_pengakuan_ypt_id' => 'SK YPT',
            'file_sk_ypt' => 'file SK YPT',
            'no_sk_ypt' => 'Nomor SK YPT',
        ]);

        // DD('MASUK');

        // DD(isset($validated['sk_llkdikti_id']));
        DB::beginTransaction();
        // // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {

            if ($validated['no_sk_dikti'] != null) {
                $validated['sk_llkdikti_id'] = null;
            }
            if ((! isset($validated['sk_llkdikti_id']))) {
                // dd('masuk');

                try {
                    $validated['no_sk'] = $validated['no_sk_dikti'];
                    $validated['tipe_sk'] = 'LLDIKTI';
                    // DB::commit();

                    $validated['users_id'] = Dosen::find($validated['dosen_id'])->users_id;
                    $validated['keterangan'] = 'Jabatan Fungsional Pegawai';
                    $validated['keperluan'] = 'JFA';

                    $sk = SK::create($validated);
                    $validated['sk_llkdikti_id'] = $sk->id;
                } catch (\Exception $e) {
                    // DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat SK LLDIKTI',
                        'error' => $e->getMessage(),
                    ], 500);
                }
            }
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

                        $validated['users_id'] = Dosen::find($validated['dosen_id'])->users_id;
                        $validated['keterangan'] = 'Jabatan Fungsional Pegawai';
                        $validated['keperluan'] = 'JFA';

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

            // if(!isset($validated['sk_pengakuan_ypt_id'])){

            // }
            // dd($validated['sk_pengakuan_ypt_id']);
            // riwayatJabatanFungsionalAkademik::create($validated);
            $jfa_update = null;
            try {
                $jfa_update = riwayatJabatanFungsionalAkademik::findOrFail($id_jfa);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Riwayat Jabatan Fungsional Akademik (JFA) ini tidak terdaftar!.');
            }

            $jfa_update->update($validated);

            DB::commit();

            // dd('ypt',$validated['sk_pengakuan_ypt_id'],'dikti',$validated['sk_llkdikti_id']);
            // DD('DONE');
            // dd('done');
            $route = redirect(route('manage.jfa.list'))->with('success', 'JFA berhasil diupdate.');
        return $this->CekReview($route, '1O3', 'MENGUBAH DATA ENTRY LEVEL- DOSEN');

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal upgrade JFA',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function validation()
    {
        return [
            [
                'dosen_id' => 'required',
                'ref_jfa_id' => 'required',
                'tmt_mulai' => 'required|date',
                'tmt_selesai' => 'nullable|date|after_or_equal:tmt_mulai',

                // Validasi SK LLDIKTI (WAJIB: harus ada file baru ATAU id existing)
                'sk_llkdikti_id' => 'required_without:file_sk_lldikti|nullable',
                'file_sk_lldikti' => 'required_without:sk_lldikti_id|nullable|file|mimes:pdf|max:2048',
                'keterangan_sk_lldikti' => 'required_without:sk_lldikti_id|nullable|string|max:200',
                'tipe_dokumen_sk_lldikti' => 'required_without:sk_lldikti_id|nullable|string|in:SK,AMANDEMEN|max:100',
                'no_sk_lldikti' => 'required_with:file_sk_lldikti|nullable|string|max:100',

                // Validasi SK YPT (OPSIONAL: tapi jika salah satu diisi, pasangannya harus valid)
                'sk_pengakuan_ypt_id' => 'nullable',
                'file_sk_ypt' => 'nullable|file|mimes:pdf|max:2048',
                'keterangan_sk_ypt' => 'required_with:file_sk_ypt|nullable|string|max:200',
                'tipe_dokumen_sk_ypt' => 'required_with:file_sk_ypt|nullable|string|in:SK,AMANDEMEN|max:100',
                'no_sk_ypt' => 'required_with:file_sk_ypt|nullable|string|max:100',
            ], [
                'required' => ':attribute Wajib Diisi',
                // Custom Error Messages
                'sk_llkdikti_id.required_without' => 'Pilih SK LLDIKTI yang tersedia atau upload file baru.',
                'file_sk_lldikti.required_without' => 'File SK LLDIKTI wajib diunggah jika tidak memilih SK yang sudah ada.',
                'no_sk_lldikti.required_with' => 'Nomor SK LLDIKTI wajib diisi untuk file yang diupload.',
                'no_sk_ypt.required_with' => 'Nomor SK YPT wajib diisi jika Anda mengupload file SK YPT baru.',
            ], [
                'dosen_id' => 'Dosen',
                'ref_jfa_id' => 'Jabatan Fungsional Akademik',
                'tmt_mulai' => 'Terakui Mulai Tanggal',
                'tmt_selesai' => 'Akhir Tanggal Selesai',
                'sk_llkdikti_id' => 'Pilihan SK LLKDIKTI',
                'file_sk_lldikti' => 'Dokumen File SK LLKDIKTI Baru',
                'no_sk_lldikti' => 'Nomor SK LLKDIKTI Baru',
                'sk_pengakuan_ypt_id' => 'Pilihan SK YPT',
                'file_sk_ypt' => 'Dokumen File SK YPT Baru',
                'no_sk_ypt' => 'Nomor SK YPT Baru',
            ],
        ];
    }
}
