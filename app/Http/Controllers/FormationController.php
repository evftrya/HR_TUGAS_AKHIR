<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\formation;
use App\Models\Level;
use App\Models\Prodi;
use App\Models\RefBagian;
use App\Models\work_position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FormationController extends Controller
{
    
    public function index()
    {   
        $formations = json_decode(Formation::with(['bagian','level_id','atasan_formation'])
                                    ->orderBy('atasan_formasi_id')
                                    ->get());
        
        // dd($formations);
        // dd('masuk');
        
            // return view('kelola_data.fakultas.list',compact('send'));
            return view('kelola_data.sotk-formasi.list', compact('formations'));
    }

    public function new()
    {
        $levels = Level::all()->sortBy('nama_level');
        $bagians = work_position::all()->sortBy('position_name');
        $formations = Formation::all()->sortBy('nama_formasi');

        return view('kelola_data.sotk-formasi.input', compact('levels', 'bagians', 'formations'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        // dd($request);
        $validated = $request->validate([
            'nama_formasi' => ['required', 'string', 'max:100'],
            'kuota' => ['required', 'integer'],
            'level_id' => ['required'],
            'atasan_formasi_id' => ['nullable'],

            'bagian' => ['required',],
        ], [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute maksimal :max karakter.',
            'integer' => ':attribute harus berupa angka.',
        ]);

        DB::beginTransaction();
        
        // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {
            $validated['work_position_id']=$validated['bagian'];
            $level = Formation::create($validated);
            DB::commit();
            // dd('done');
            return redirect(route('manage.formasi.list'))->with('success', 'Formasi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Formasi',
                'error' => $e->getMessage()
            ], 500);
        }
        // return redirect()->route('manage.formasi.list')->with('success', 'Data Formasi Berhasil Ditambahkan');
    }

    public function update(Request $request, $idFormasi)
    {
        $levels = Level::all()->sortBy('nama_level');
        $bagians = RefBagian::all()->sortBy('nama_bagian');
        $prodis = Prodi::all()->sortBy('nama_prodi');
        $fakultas = Fakultas::all()->sortBy('nama_fakultas');
        $formations = Formation::all()->sortBy('nama_formasi');
        $formation_target = Formation::find($idFormasi);

        return view('kelola_data.sotk-formasi.edit', compact('levels', 'bagians', 'prodis', 'fakultas', 'formations', 'formation_target'));
    }

    public function update_data(Request $request, $idFormasi)
    {
        // dd($request->all());
        $validated = $request->validate([
            'nama_formasi' => ['required', 'string', 'max:100'],
            'kuota' => ['required', 'integer'],
            'level_id' => ['required'],
            'atasan_formasi_id' => ['nullable'],

            'bagian' => ['nullable','required_without_all:prodi,fakultas'],
            'prodi' => ['nullable','required_without_all:bagian,fakultas'],
            'fakultas' => ['nullable','required_without_all:bagian,prodi'],
        ], [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute maksimal :max karakter.',
            'integer' => ':attribute harus berupa angka.',
            'required_without_all' => 'Minimal salah satu dari bagian / prodi / fakultas harus diisi.',
        ]);

        DB::beginTransaction();
        try {
            $formation = Formation::where('id', $idFormasi)->update($validated);
            DB::commit();
            return redirect(route('manage.formasi.list'))->with('success', 'Formasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui Formasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
