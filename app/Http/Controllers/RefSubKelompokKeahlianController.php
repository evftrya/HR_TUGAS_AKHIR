<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\KelompokKeahlian;
use App\Models\RefSubKelompokKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefSubKelompokKeahlianController extends Controller
{
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
        return view('kelola_data.kelompok_keahlian.sub.list', compact('database', 'dosen'));

        // return view('nama_file_view', compact('database'));
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

            $route = redirect()->back()->with('success', 'Sub Kelompok Keahlian berhasil ditambahkan');
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

            return redirect()->back()->with('success', 'Sub Kelompok Keahlian berhasil diperbarui!.');
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
