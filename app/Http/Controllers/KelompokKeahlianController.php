<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\KelompokKeahlian;
use App\Models\Work_Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelompokKeahlianController extends Controller
{
    public function index()
    {
        $query = DB::select('
            SELECT
                m.id as fakultas_id, m.position_name as fakultas_name, m.kode as fakultas_code,
                a.id as kk_id, a.nama as kk_name, a.kode as kk_code,   a.deskripsi as kk_deskripsi,
                b.id as sub_kk_id, b.nama as sub_kk_name, b.kode as sub_kk_code, b.deskripsi as sub_kk_deskripsi
            FROM kelompok_keahlian a
            JOIN work_positions m ON m.id = a.fakultas_id
            LEFT JOIN ref_sub_kelompok_keahlians b ON b.kk_id = a.id
        ');
        $registryData = collect($query)->groupBy('fakultas_id')->map(function ($items) {
            $first = $items->first();

            return [
                'id' => $first->fakultas_id,
                'nama_fakultas' => $first->fakultas_name,
                'kode_fakultas' => $first->fakultas_code,
                'kks' => $items->groupBy('kk_id')->map(function ($kkItems) {
                    $kkFirst = $kkItems->first();

                    return [
                        'id' => $kkFirst->kk_id,
                        'nama_kk' => $kkFirst->kk_name,
                        'kode_kk' => $kkFirst->kk_code,
                        'deskripsi' => $kkFirst->kk_deskripsi,
                        'subs' => $kkItems->whereNotNull('sub_kk_id')->map(function ($sub) {
                            return [
                                'id' => $sub->sub_kk_id,
                                'nama_sub_kk' => $sub->sub_kk_name,
                                'kode_sub_kk' => $sub->sub_kk_code,
                                'deskripsi_sub' => $sub->sub_kk_deskripsi,
                            ];
                        })->values()->all(),
                    ];
                })->values()->all(),
            ];
        })->values()->all();

        // Ambil data untuk dropdown select di form
        $fakultas = Work_Position::where('type_work_position', 'Fakultas')
            ->orderBy('position_name', 'asc')
            ->get();
        $kks = KelompokKeahlian::all();
        // dd($registryData, $fakultas, $kk);

        // return view('nama_file_blade_anda', compact('registryData', 'fakultas'));
        return view('kelola_data.kelompok_keahlian.list', compact('registryData', 'fakultas', 'kks'));
    }

    public function create()
    {
        return view('kelola_data.kelompok_keahlian.input');
    }

    public function store(Request $request)
    {
        // dd($request);

        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            $cek_exist_code = KelompokKeahlian::where('kode', $request->kode)->first();
            $cek_exist_fakultas = Work_Position::where([
                ['id', '=', $request->fakultas_id],
                ['type_work_position', '=', 'Fakultas'],
            ])->first();

            if ($cek_exist_code) {
                throw new \Exception('Kode Kelompok Keahlian ini sudah terdaftar, mohon coba yang lain!.');
            }

            if (! $cek_exist_fakultas) {
                throw new \Exception('Fakultas tidak terdaftar di sistem, mohon coba yang lain!.');
            }

            $save = KelompokKeahlian::create($validated);
            if (! $save) {
                throw new \Exception('Terjadi masalah saat menyimpan data, mohon coba lagi dalam beberapa saat!.');
            }
            DB::commit();

            return redirect()->route('manage.kelompok-keahlian.list')->with('success', 'Kelompok Keahlian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error_alert' => $e->getMessage()]);
        }

    }

    public function show($id)
    {
        try {
            $kelompokKeahlian = null;
            try {
                $kelompokKeahlian = KelompokKeahlian::with('dosen.pegawai')->findOrFail($id);
                // $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Kelompok Keahlian ini tidak terdaftar!.');
            }

            // Ambil semua dosen yang belum tergabung di KK ini
            $allDosen = \App\Models\Dosen::with('pegawai')
                ->whereDoesntHave('kelompokKeahlian', function ($q) use ($id) {
                    $q->where('kelompok_keahlian.id', $id);
                })->get();

            // Dosen nonaktif: opsional, misal dosen yang pernah tergabung lalu di-nonaktifkan (detach)
            // Jika ingin menampilkan dosen yang tidak lagi tergabung, perlu histori atau soft delete pada pivot
            // Untuk sementara, kosongkan saja jika belum ada logika nonaktif sebenarnya
            $nonaktifDosen = [];

            return view('kelola_data.kelompok_keahlian.view', compact('kelompokKeahlian', 'allDosen', 'nonaktifDosen'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $kelompokKeahlian = null;
            try {
                $kelompokKeahlian = KelompokKeahlian::with('dosen.pegawai')->findOrFail($id);
                // $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Kelompok Keahlian ini tidak terdaftar!.');
            }

            return view('kelola_data.kelompok_keahlian.edit', compact('kelompokKeahlian'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            try {
                $cek_kk = KelompokKeahlian::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Kode Kelompok Keahlian ini tidak terdaftar!.');
            }
            $cek_exist_fakultas = Work_Position::where([
                ['id', '=', $request->fakultas_id],
                ['type_work_position', '=', 'Fakultas'],
            ])->first();

            if (! $cek_exist_fakultas) {
                throw new \Exception('Fakultas tidak terdaftar di sistem, mohon coba yang lain!.');
            }

            $save = $cek_kk->update($validated);
            if (! $save) {
                throw new \Exception('Terjadi masalah saat menyimpan data, mohon coba lagi dalam beberapa saat!.');
            }
            DB::commit();

            return redirect()->back()->with('success', 'Kelompok Keahlian berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error_alert' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        // try {
        //     $kelompokKeahlian = null;
        //     try {
        //         $kelompokKeahlian = KelompokKeahlian::with('dosen.pegawai')->findOrFail($id);
        //         $kelompokKeahlian->delete();
        //         // $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
        //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //         throw new \Exception('Kelompok Keahlian ini tidak terdaftar!.');
        //     }

        //     return redirect()->route('manage.kelompok-keahlian.list')->with('success', 'Kelompok Keahlian berhasil dihapus');
        // } catch (\Exception $e) {

        //     return redirect()->back()->with('error_alert', $e->getMessage());
        // }
    }

    public function nonaktifkan(Request $request, $id)
    {
        try {

            $validated = $request->validate([
                'dosen_id' => 'required|exists:dosens,id',
            ]);

            $kelompokKeahlian = null;
            try {
                $kelompokKeahlian = KelompokKeahlian::with('dosen.pegawai')->findOrFail($id);
                // $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Kelompok Keahlian ini tidak terdaftar!.');
            }
            $kelompokKeahlian->dosen()->detach($validated['dosen_id']);

            return redirect()->back()->with('success', 'Dosen berhasil dinonaktifkan dari kelompok keahlian');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function assignDosen(Request $request, $id)
    {
        try {

            $validated = $request->validate([
                'dosen_id' => 'required|array',
                'dosen_id.*' => 'exists:dosens,id',
            ]);

            $kelompokKeahlian = null;
            try {
                $kelompokKeahlian = KelompokKeahlian::with('dosen.pegawai')->findOrFail($id);
                // $cek_kode = RefJenjangPendidikan::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Kelompok Keahlian ini tidak terdaftar!.');
            }
            $kelompokKeahlian->dosen()->syncWithoutDetaching($validated['dosen_id']);

            return redirect()->back()->with('success', 'Dosen berhasil ditambahkan ke kelompok keahlian');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function pegawaiList()
    {
        $dosen = Dosen::with('kelompokKeahlian', 'pegawai')->get();
        // dd($dosen);

        return view('kelola_data.kelompok_keahlian.pegawai_list', compact('dosen'));
    }

    public function validation()
    {
        return [
            [
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|max:50',
                'deskripsi' => 'required|string|max:255',
                'fakultas_id' => ['required','string','max:100',
                    Rule::exists('work_positions', 'id')->where(function ($query) {
                        $query->where('type_work_position', 'Fakultas');
                    }),
                ],
            ], [
                '*.required' => ':attribute Wajib Diisi',
                '*.exists' => ':attribute tidak valid!',
            ], [
                'nama' => 'Nama Kelompok Keahlian',
                'kode' => 'Singkatan Kelompok Keahlian',
                'fakultas_id' => 'Fakultas Kelompok Keahlian',
                'deskripsi' => 'Deskripsi Kelompok Keahlian',
            ],
        ];

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
