<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Work_Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakultasController extends Controller
{
    public string $aksi = 'Fakultas';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultas = Fakultas::where('type_work_position', 'Fakultas')->withCount('prodi as prodi_count')->paginate(15);
        // dd($fakultas);
        $this->MakeLog('User Mengakses Halaman List '.$this->aksi);

        return view('kelola_data.fakultas.index', compact('fakultas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->MakeLog('User Mengakses Halaman Tambah '.$this->aksi);

        $route = view('kelola_data.fakultas.create');
        return $this->CekReview($route, '1ZY1', 'MELIHAT DATA FAKULTAS');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DT
        try {
            $validated = $request->validate(
                [
                    'kode' => [
                        'required',
                        'string',
                        'max:5',
                        'unique:work_positions,kode',
                    ],
                    'position_name' => [
                        'required',
                        'string',
                        'max:100',
                    ],
                ],
                [
                    'required' => ':attribute wajib diisi.',
                    'string' => ':attribute harus berupa text.',
                    'max' => ':attribute maksimal :max karakter.',
                    'unique' => ':attribute sudah digunakan.',

                    'kode.required' => 'Kode Posisi wajib diisi.',
                    'kode.unique' => 'Kode Posisi sudah terdaftar pada bagian dalam sistem!, Silahkan Coba yang lain!.',
                ],
                [
                    'kode' => 'Kode Fakultas',
                    'position_name' => 'Nama Posisi',
                ]
            );

            $validated['singkatan'] = $validated['kode'];

            $validated['type_work_position'] = 'Fakultas';

            $save = Work_Position::create($validated);
            $this->MakeLog('User Berhasil Menambahkan Data '.$this->aksi, ['data' => $save]);

            $route = redirect()->route('manage.fakultas.index')
                ->with('success', 'Fakultas berhasil ditambahkan.');
        return $this->CekReview($route, '1ZY3', 'MENAMBAH DATA FAKULTAS');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->MakeLog('User Gagal Menambahkan Data '.$this->aksi, ['alasan' => $e->getMessage()]);

            return redirect()->route('manage.fakultas.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fakultas = Work_Position::where('id', $id)->where('type_work_position', 'Fakultas')->with('children')->firstOrFail();
        $this->MakeLog('User melihat Data '.$this->aksi, ['data' => $fakultas]);

        return view('kelola_data.fakultas.show', compact('fakultas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fakulta = Work_Position::where('id', $id)->where('type_work_position', 'Fakultas')->firstOrFail();
        $this->MakeLog('User Berhasil Mengakses Halaman Edit '.$this->aksi, ['data' => $fakulta]);

        return view('kelola_data.fakultas.edit', compact('fakulta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fakulta = Work_Position::where('id', $id)->where('type_work_position', 'Fakultas')->firstOrFail();
        $old = $fakulta;
        $validated = $request->validate([
            'kode' => 'required|string|max:100|unique:work_positions,kode,'.$fakulta->id,
            'position_name' => 'required|string|max:100',
            // 'singkatan' => 'nullable|string|max:20',
        ]);

        $validated['singkatan'] = $validated['kode'];

        $save = $fakulta->update($validated);
        $this->MakeLog('User Berhasil Memperbarui Data '.$this->aksi, ['data lama' => $old, 'data baru' => $save]);

        $route = redirect()->route('manage.fakultas.index')
            ->with('success', 'Fakultas berhasil diperbarui.');
        return $this->CekReview($route, '1ZY2', 'MENGUBAH DATA FAKULTAS');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fakulta = Work_Position::where('id', $id)->where('type_work_position', 'Fakultas')->firstOrFail();
        $data = $fakulta;
        $fakulta->delete();
        $this->MakeLog('User Berhasil Menghapus Data '.$this->aksi, ['data dihapus' => $data]);

        return redirect()->route('manage.fakultas.index')
            ->with('success', 'Fakultas berhasil dihapus.');
    }
}
