<?php

namespace App\Http\Controllers;

use App\Models\Coe;
use App\Models\Dosen;
use App\Models\DosenHasCOE;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenHasCOEController extends Controller
{
    public function list()
    {

        $data = DosenHasCOE::with(['dosen.pegawai', 'coe.research'])
            ->get()
            ->map(function ($item) {
                $item->is_active = is_null($item->tmt_selesai)
                    || Carbon::parse($item->tmt_selesai)->gte(Carbon::today());

                return $item;
            });

        return view('kelola_data.coe.dosen-has-coe.list', compact('data'));
    }

    public function new()
    {
        $dosen = Dosen::with('pegawai')
            ->get()
            ->sortBy(function ($item) {
                return $item->pegawai->nama_lengkap ?? '';
            });
        $coe = Coe::all()->sortBy('nama_coe');

        return view('kelola_data.coe.dosen-has-coe.input', compact('dosen', 'coe'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();

            $cek_exist_kode = DosenHasCOE::where('dosen_id', $request->dosen_id)->where('coe_id', $request->coe_id)->first();
            if ($cek_exist_kode) {
                throw new \Exception('Dosen dengan CoE ini sudah terdaftar!.');
            }

            $save = DosenHasCOE::create($validated);
            if (! $save) {
                throw new \Exception('Gagal menyimpan data!.');
            }
            DB::commit();

            return redirect(route('manage.coe.dosen.list'))->with('success', 'Pemetaan Dosen terhadap CoE Berhasil ditambahkan!.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function edit($id_coe)
    {
        try {
            if ($id_coe == null) {
                throw new \Exception('Tidak ada research Rujukan!.');
            }
            $cek_exist_kode = null;
            try {
                $cek_exist_kode = DosenHasCOE::findOrFail($id_coe);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $f) {
                throw new \Exception('Pemetaan Dosen ke CoE ini tidak terdaftar!.');
            }

            $data = $cek_exist_kode;
            $dosen = Dosen::with('pegawai')
                ->get()
                ->sortBy(function ($item) {
                    return $item->pegawai->nama_lengkap ?? '';
                });
            $coe = Coe::with('research')
                ->orderBy('nama_coe')
                ->get();

            return view('kelola_data.coe.dosen-has-coe.update', compact('data', 'dosen', 'coe'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);
        try {
            DB::beginTransaction();
            $cek_exist_kode = null;
            try {
                $cek_exist_kode = DosenHasCOE::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $f) {
                throw new \Exception('Pemetaan Dosen ke CoE ini tidak terdaftar!.');
            }

            $save = $cek_exist_kode->update($validated);
            if (! $save) {
                throw new \Exception('Gagal memperbarui data!.');
            }
            DB::commit();

            return redirect(route('manage.coe.dosen.list'))->with('success', 'Data Research Berhasil diperbaharui!.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function validation()
    {
        return [
            [
                'dosen_id' => ['required', 'string', 'max:50', 'exists:dosens,id'],
                'coe_id' => ['required', 'string', 'max:50', 'exists:coe,id'],
                'tmt_mulai' => ['required', 'date'],
                'tmt_selesai' => ['nullable', 'date'],
            ], [
                'required' => ':attribute wajib diisi',
                'string' => ':attribute harus berupa teks',
                'max' => ':attribute maksimal :max karakter',
            ], [
                'dosen_id' => 'Pilihan Dosen',
                'coe_id' => 'CoE',
                'tmt_mulai' => 'Diakui Mulai Tanggal',
                'tmt_selesai' => 'Selesai Pada Tanggal',
            ],
        ];
    }

    public function History($id_user)
    {
        try {
            $cek_user = Dosen::where('users_id', $id_user)->first();
            if (! $cek_user) {
                throw new \Exception('Data Dosen tidak ditemukan!.');
            }
            $history = DosenHasCOE::with('coe.research')
                ->where('dosen_id', $cek_user->id)
                ->orderByDesc('tmt_mulai')
                ->get();
            $user = (new ProfileController)->based_user_data($id_user);

            // dd($history);
            return view('kelola_data.pegawai.view.history.coe', compact('history', 'user'));
        } catch (\Exception $e) {

        }
    }
}
