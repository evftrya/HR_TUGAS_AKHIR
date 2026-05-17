<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\RefPangkatGolongan;
use App\Models\RefStatusPegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RefPangkatGolonganController extends Controller
{
    public function list()
    {
        $this->MakeLog('User Mangakses halaman list referensi Pangkat-golongan');
        $data = RefPangkatGolongan::all()->sortBy('golongan');
        return view('kelola_data.ref-pangkat-golongan.list', compact('data'));
    }

    public function new()
    {
        $this->MakeLog('User Mangakses halaman Tambah Pangkat-golongan');
        $route = view('kelola_data.ref-pangkat-golongan.input');
            return $this->CekReview($route, '1Y3', 'MELIHAT DATA REFERENSI PANGKAT & GOLONGAN');

    }

    public function edit($id_rpg)
    {
        $this->MakeLog('User Mangakses halaman Edit Pangkat-golongan', ['id Pangkat Golongan' => $id_rpg]);
        $rpg = RefPangkatGolongan::where('id', $id_rpg)->first();
        if (!$rpg) {
            $this->MakeLog('User Gagal Mangakses halaman Edit Pangkat-golongan');
            return $this->handleRedirectBack()->with('error_alert', 'Master Data Pangkat golongan tidak ditemukan!.');
        }
        // $this->MakeLog('User Berhasil Mangakses halaman Edit Pangkat-golongan');
        $this->MakeLog('User Berhasil Mangakses halaman Edit Pangkat-golongan', ['id Pangkat Golongan' => $rpg]);


        $route = view('kelola_data.ref-pangkat-golongan.update', compact('rpg'));
        return $this->CekReview($route, '1Y3', 'MELIHAT DATA REFERENSI PANGKAT & GOLONGAN');
    }

    public function update(Request $request)
    {
        $cek_pg = null;
        try {
            $cek_pg = RefPangkatGolongan::findOrFail($request->id);
            $this->MakeLog('User Mengedit Master Data Pangkat Golongan');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->handleRedirectBack()->with('error_alert','Pangkat Golongan ini tidak terdaftar!.');
        }
        $validation = $this->validation($request, $request->id);
        $validated = $request->validate($validation[0],$validation[1],$validation[2]);
        // dd($validated);
        try {
            $old = $cek_pg;

            if (!$cek_pg) {
                throw new \Exception('Bagian Tidak Ditemukan!.');
            }
            DB::beginTransaction();
            $capitalize = ucwords($request->pangkat);
            $request['pangkat'] = $capitalize;


            // dd($validated);
            $save = $cek_pg->update($request->all());
            $new = $save;
            if (!$save) {
                throw new \Exception('Terjadi masalah ketika melakukan proses simpan master data pangkat & golongan!.');
            }
            $this->MakeLog('User Berhasil Mengedit Master Data Pangkat Golongan', [
                'Data Sebelumnya' => $old,
                'Data Setelahnya' => $new,
            ]);
            $route = redirect(route('manage.pangkat-golongan.ref.list'))->with('success', 'Master Data Pangkat Golongan berhasil diperbaharui!');
            DB::commit();
            return $this->CekReview($route, '1Y2', 'MENGUBAH DATA REFERENSI PANGKAT & GOLONGAN');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Mengedit Master Data Pangkat Golongan', ['alasan' => $e->getMessage()]);
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->MakeLog('User Submit Form Tambah Master Data Pangkat Golongan Baru');
        $validation = $this->validation($request);
        $validated = $request->validate($validation[0],$validation[1],$validation[2]);
        // dd($validated);
        try {
            DB::beginTransaction();
            $capitalize = ucwords($request->pangkat);
            $request['pangkat'] = $capitalize;


            // dd($validated);
            $save = RefPangkatGolongan::create($request->all());
            if (!$save) {
                throw new \Exception('Terjadi masalah ketika melakukan proses simpan status pegawai!.');
            }
            DB::commit();

            $this->MakeLog('User Berhasil Tambah Master Data Pangkat Golongan Baru', ['data' => $save]);
            $route = redirect(route('manage.pangkat-golongan.ref.list'))->with('success', 'Master Data Pangkat Golongan berhasil ditambahkan!');
            return $this->CekReview($route, '1Y1', 'MENAMBAH DATA REFERENSI PANGKAT & GOLONGAN');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Tambah Master Data Pangkat Golongan Baru', ['alasan' => $e->getMessage()]);
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function validation($request, $id=null)
    {
        $id = $id==null?'':','.$id;
        return [
            [
                'golongan'   => 'required|string|max:10',
                'pangkat'   => 'required|string|max:100|regex:/^(?=.*[A-Za-z])[A-Za-z0-9\s.]+$/',
            ],
            [
                'pangkat.unique' => 'Nama Pangkat ini dengan Golongan yang sama sudah terdaftar!.',
                'required' => ':attribute tidak boleh kosong!',
                'regex'    => ':attribute harus mengandung huruf dan tidak boleh hanya angka. Hanya boleh kombinasi huruf dan angka.',
            ],
            [
                'pangkat' => 'Pangkat',
                'golongan' => 'Golongan',
            ]
        ];
    }
}
