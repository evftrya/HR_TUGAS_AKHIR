<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\DosenHasKK;
use App\Models\RefSubKelompokKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            if ($is_dosen_has_kk) {
                throw new \Exception('Dosen sudah terdaftar di kelompok keahlian mohon nonaktifkan terlebih dahulu.');
            }

            $validated['is_active'] = 1;
            $create = DosenHasKK::create($validated);
            if ($create) {
                DB::commit();
                $this->MakeLog('User Berhasil menambah data Dosen dengan KK', ['data' => $create]);

                $route = $this->handleRedirectBack()->with('success', 'Berhasil menambahkan dosen ke Sub Kelompok Keahlian');

                return $this->CekReview($route, '1D4', 'MEMETAKAN DOSEN KEPADA KELOMPOK KEAHLIAN');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Menambahkan Dosen Kepada KK', ['alasan' => $e->getMessage()]);

            return $this->handleRedirectBack()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function new()
    {
        $sub_kk = RefSubKelompokKeahlian::with('KK')
            ->get()
            ->sortBy([
                fn ($item) => $item->KK->kode ?? '',
                fn ($item) => $item->nama,
            ]);
        $dosens = Dosen::select('dosens.*')
            ->join('users', 'users.id', '=', 'dosens.users_id')
            ->where('users.is_active', '<>', 0)
            ->orderBy('users.nama_lengkap')
            ->with('pegawai')
            ->get();

        return view('kelola_data.kelompok_keahlian.dosen-has-kk.input', compact('sub_kk', 'dosens'));
    }

    public function index()
    {
        $results = DB::select('
            SELECT
                m.id as fakultas_id, m.position_name as fakultas_name, m.kode as fakultas_code,
                a.id as kk_id, a.nama as kk_name, a.kode as kk_code,   a.deskripsi as kk_deskripsi,

                b.id as sub_kk_id, b.nama as sub_kk_name, b.kode as sub_kk_desc, b.deskripsi as sub_kk_deskripsi,
                d.id as dosen_id, e.id as users_id, e.nama_lengkap as dosen_name, c.id as dosen_has_kk_id,
                y.position_name as prodi
            FROM kelompok_keahlian a
            JOIN work_positions m ON m.id = a.fakultas_id
            LEFT JOIN ref_sub_kelompok_keahlians b ON b.kk_id = a.id
            JOIN dosen_has_kk c ON c.sub_kk_id = b.id
            LEFT JOIN dosens d ON d.id = c.dosen_id
            LEFT JOIN work_positions y ON y.id = d.prodi_id
            LEFT JOIN users e ON e.id = d.users_id

            where c.is_active=1
        ');

        // $dosen = Dosen::with('pegawai_aktif')->get()->sortBy('pegawai_aktif.nama_lengkap');
        // dd($dosen);
        $dosen = Dosen::with('pegawai_aktif')
            ->get()
            ->sortBy(function ($item) {
                // Mengurutkan berdasarkan nama_lengkap, jika null taruh di bawah atau beri string kosong
                return $item->pegawai_aktif->nama_lengkap ?? '';
            });
        // dd($dosen);

        $database = collect($results)->groupBy('fakultas_id')->map(function ($fakultasGroup) {
            $firstFak = $fakultasGroup->first();

            return [
                'id' => $firstFak->fakultas_id,
                'name' => $firstFak->fakultas_name,
                'code' => $firstFak->fakultas_code,
                'kks' => $fakultasGroup->groupBy('kk_id')->map(function ($kkGroup) {
                    $firstKk = $kkGroup->first();

                    return [
                        'id' => $firstKk->kk_id,
                        'name' => $firstKk->kk_name,
                        'code' => $firstKk->kk_code,
                        'subs' => $kkGroup->groupBy('sub_kk_id')->map(function ($subGroup) {
                            $firstSub = $subGroup->first();
                            if (! $firstSub->sub_kk_id) {
                                return null;
                            }

                            return [
                                'id' => $firstSub->sub_kk_id,
                                'name' => $firstSub->sub_kk_name,
                                'code' => $firstSub->sub_kk_desc,
                                'dosens' => $subGroup->filter(fn ($item) => $item->dosen_id != null)
                                    ->map(function ($dosen) {
                                        return [
                                            'id_pemetaan' => $dosen->dosen_has_kk_id,
                                            'nama' => $dosen->dosen_name,
                                            'prodi' => $dosen->prodi,
                                            'foto' => 'https://i.pravatar.cc/150?u='.$dosen->users_id,
                                        ];
                                    })->values()->toArray(),
                            ];
                        })->filter()->values()->toArray(),
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();

        // dd($database);
        return view('kelola_data.kelompok_keahlian.dosen-has-kk.list', compact('database', 'dosen'));

        // return view('nama_file_view', compact('database'));
    }

    public function validation(Request $request, $id = null)
    {
        return $validated = $request->validate([
            'dosen_id' => [
                'required',
                'exists:dosens,id',
                Rule::unique('dosen_has_kk', 'dosen_id')
                    ->where('sub_kk_id', $request->sub_kk_id)
                    ->ignore($id),
            ],
            'sub_kk_id' => ['required', 'exists:ref_sub_kelompok_keahlians,id'],
        ], [
            'dosen_id.unique' => 'Dosen dengan Sub KK ini sudah terdaftar!.',
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute Tidak Terdaftar!.',

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

            if ($cek_exist_id->is_active == 0) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian ini memang sudah Dilepas!.');
            }
            // $validated = $this->validation($request);
            DB::beginTransaction();

            $cek_exist_id->is_active = 0;
            $save = $cek_exist_id->save();
            if ($save) {
                DB::commit();
                $this->MakeLog('User Berhasil melepas Dosen dari KK', ['data' => $save]);

                return $this->handleRedirectBack()->with('success', 'Berhasil melepaskan dosen dari Sub Kelompok Keahlian');

            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Melepas Dosen dari KK', ['alasan' => $e->getMessage()]);

            return $this->handleRedirectBack()
                ->with('error_alert', $e->getMessage());
        }
    }

    public function Aktifkan_Pemetaan($DosenHasKK_id = null)
    {

        try {
            if ($DosenHasKK_id == null) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian belum ada.');
            }

            $cek_exist_id = DosenHasKK::where('id', $DosenHasKK_id)->first();
            if (! $cek_exist_id) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian tidak terdaftar.');
            }

            if ($cek_exist_id->is_active == 1) {
                throw new \Exception('Pemetaan Dosen ke Sub Kelompok Keahlian ini memang sudah Aktif!.');
            }
            // $validated = $this->validation($request);
            DB::beginTransaction();

            $cek_exist_id->is_active = 1;
            $save = $cek_exist_id->save();
            if ($save) {
                DB::commit();
                $this->MakeLog('User Berhasil Memetakan kembali Dosen ke Sub KK', ['data' => $save]);

                return $this->handleRedirectBack()->with('success', 'Berhasil memetakan kembali dosen ke sub kelompok keahlian');

            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Melepas Dosen dari KK', ['alasan' => $e->getMessage()]);

            return $this->handleRedirectBack()
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
            $aktifDate = 'AND (a.tmt_selesai IS NULL OR a.tmt_selesai >= ?)';
            $bindings[] = $request->filter_date;
        } else {
            $aktifDate = 'AND (a.tmt_selesai IS NULL OR a.tmt_selesai >= NOW())';
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
        WHERE a3.type_work_position = 'Fakultas'", $bindings

        );
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
        $this->MakeLog('User Berhasil Mengakses halaman struktur KK');

        $route = view('kelola_data.kelompok_keahlian.dosen-has-kk.struktur', compact('database', 'filter_date'));

        return $this->CekReview($route, '1D5', 'MELIHAT DAFTAR DOSEN DENGAN KELOMPOK KEAHLIAN', true);

    }

    public function table(Request $request)
    {
        $data = DosenHasKK::with(['dosen.pegawai', 'subKK.KK.fakultas']);

        if ($request->input('decition') != 'all') {
            $data->where('is_active', true);
        }

        $data = $data->get();

        // dd($data);

        // dd($data);
        $this->MakeLog('User Berhasil Mengakses halaman Data Table KK');

        return view('kelola_data.kelompok_keahlian.dosen-has-kk.table', compact('data'));
    }

    public function riwayat($id_user)
    {
        if ($this->onlyOwnerAdminAndSdm($id_user) == true) {
            $dosen = Dosen::where('users_id', $id_user)->first();
            if (! $dosen) {
                return $this->handleRedirectBack()->with('error_alert', 'Dosen Tidak Ditemukan!.');
            }
            $user = (new ProfileController)->based_user_data($id_user);
            $history = DosenHasKK::with('subKK.KK.fakultas')->where('dosen_id', $dosen->id)->get()->sortByDesc('created_at');
            $this->MakeLog('User Berhasil Mengakses halaman Riwayat KK dari Dosen Terkait', ['dosen terkait' => $user->nama_lengkap]);

            $route = view('kelola_data.pegawai.view.history.kelompok-keahlan', compact('user', 'history'));

            return $this->CekReview($route, '1D7', 'MELIHAT RIWAYAT PEMETAAN KK BY DOSEN TERKAIT');
        }

        return redirect(route('profile.personal-info', ['idUser' => session('account')['id']]))->with('error_alert', 'Anda hanya boleh mengelola data anda sendiri!.');

    }
}
