<?php

namespace App\Http\Controllers;

use App\Models\Level;
// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public string $aksi = 'Level';

    public function index()
    {
        $levels = Level::all();
        foreach ($levels as $level) {
            $level['atasan'] = Level::where('id', $level->atasan_level)->first();
        }
        // dd($levels);

        // dd('masuk');

        // return view('kelola_data.fakultas.list',compact('send'));
        $this->MakeLog('User Mengakses Halaman List Data '.$this->aksi);

        return view('kelola_data.sotk-level.list', compact('levels'));
    }

    public function new()
    {
        $levels = Level::all()->sortBy('nama_level');
        // dd($levels);
        $this->MakeLog('User Mengakses Halaman Tambah Data '.$this->aksi);

        return view('kelola_data.sotk-level.input', compact('levels'));
    }

    public function view()
    {
        // dd($levels);
        $this->MakeLog('User Mengakses Halaman Tambah Data '.$this->aksi);

        return view('kelola_data.sotk-level.input');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            // Data diri (umum)
            'nama_level' => ['required', 'string', 'max:50'],
            'singkatan_level' => ['required', 'string', 'max:20'],
            'atasan_level' => ['required', 'string',  'max:50'],
        ], [
            // Pesan error umum
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute maksimal :max karakter.',
        ]);
        DB::beginTransaction();
        $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {
            $level = Level::create($validated);
            DB::commit();
            $this->MakeLog('User Menambah Data '.$this->aksi, ['data' => $level]);

            return redirect(route('manage.level.list'))->with('success', 'Level berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Menambah Data '.$this->aksi, ['alasan' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Level',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update($idLevel)
    {
        // dd('update',$idLevel);
        // $users;
        $level_target = Level::find($idLevel);
        $levels = Level::all()->sortBy('nama_level');

        // dd($level_target);
            $this->MakeLog('User Mengakses Halaman Ubah Data '.$this->aksi, ['data' => $level_target]);

        return view('kelola_data.sotk-level.update', compact('level_target', 'levels', 'idLevel'));
    }

    public function update_data(Request $request, $idLevel)
    {
        $validated = $request->validate([
            // Data diri (umum)
            'nama_level' => ['required', 'string', 'max:50'],
            'singkatan_level' => ['required', 'string', 'max:20'],
            'atasan_level' => ['required', 'string',  'max:50'],
            'urut' => ['required', 'string',  'max:3'],
        ], [
            // Pesan error umum
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute maksimal :max karakter.',
        ]);
        DB::beginTransaction();
        $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {
            // dd('masuk');

            $level = Level::where('id', $idLevel)->first();
            $old = $level;
            $save = $level->update($validated);
            DB::commit();

            // dd($level);
            $this->MakeLog('User Mengubah Data '.$this->aksi, ['data lama' => $old,'data baru' => $level]);

            return redirect(route('manage.level.list'))->with('success', 'Level berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Mengubah Data '.$this->aksi, ['alasan' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate Level',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function create(Request $request){
    //     $request->all();
    // }
}
