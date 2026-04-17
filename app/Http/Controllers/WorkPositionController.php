<?php

namespace App\Http\Controllers;

use App\Models\Work_Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkPositionController extends Controller
{
    public function list()
    {
        $work_positions = Work_Position::all()->sortBy('position_name');
        return view('kelola_data.bagian.list', compact('work_positions'));
    }

    public function new()
    {
        return view('kelola_data.bagian.input');
    }

    public function edit(Request $request, $id_wp)
    {
        $wp = Work_Position::where('id', $id_wp)->first();
        if (!$wp) {
            return redirect()->back()->with('error_alert', 'Data Bagian Kerja Tidak Ditemukan!');
        }
        return view('kelola_data.bagian.update', compact('wp'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate($this->validation());
        // dd($request, $validated);

        try {
            DB::beginTransaction();

            $save = Work_Position::create($request->all());
            if (!$save) {
                throw new \Exception('Terjadi masalah ketika melakukan proses simpan bagian!.');
            }
            DB::commit();
            return redirect(route('manage.bagian.list'))->with('success', 'Data bagian berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id_wp)
    {
        // dd($request->all());
        $validated = $request->validate($this->validation());
        // dd($validated);
        try {
            DB::beginTransaction();

            $cek_wp = Work_Position::findOrFail($id_wp);

            if (!$cek_wp) {
                throw new \Exception('Bagian Tidak Ditemukan!.');
            }
            // dd($validated);
            $save = $cek_wp->update($request->all());
            if (!$save) {
                throw new \Exception('Terjadi masalah ketika melakukan proses simpan bagian!.');
            }
            // dd($save, $cek_wp, $val);
            DB::commit();
            return redirect(route('manage.bagian.list'))->with('success', 'Data bagian berhasil diperbaharui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_alert', $e->getMessage());
        }
    }

    public function validation()
    {
        return [
            [
                'position_name'   => 'required|string|max:255',
                'type_work_position'   => 'required|in:Bagian,Direktorat,Program Studi,Fakultas',
                'type_pekerja'  => 'required|in:Dosen,TPA,Keduanya',
                'kode'     => 'required|string|max:20',
            ],
            [
                'required' => ':attribute tidak boleh kosong!',
                'in'       => 'Pilihan pada :attribute tidak tersedia.',
            ],
            [
                'position_name' => 'Nama Bagian',
                'type_work_position' => 'Tipe Bagian',
                'type_pekerja' => 'Tipe Pekerja',
                'kode' => 'Singkatan Bagian',
            ]
        ];
    }
}
