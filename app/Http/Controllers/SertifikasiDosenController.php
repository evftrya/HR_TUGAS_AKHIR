<?php

namespace App\Http\Controllers;

use App\Models\SertifikasiDosen;
use App\Models\Dosen;
use App\Models\sertifikasi_owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SertifikasiDosenController extends Controller
{
    public function index()
    {
        $sertifikasi = SertifikasiDosen::all();
        return view('kelola_data.sertifikasi_dosen.list', compact('sertifikasi'));
    }

    public function create()
    {
        // $dosens = [];

        $all_pegawai = Dosen::select('dosens.*')
            ->join('users', 'users.id', '=', 'dosens.users_id')
            ->where('users.is_active', 1)
            ->orderBy('users.tipe_pegawai', 'desc')
            ->orderBy('users.nama_lengkap', 'asc')
            ->with('pegawai_aktif') // optional, kalau masih butuh relasi
            ->get();
        // dD($all_pegawai, $all_pegawai[0]->pegawai_aktif);
        $all_sertifikasi = SertifikasiDosen::all()->sortBy('nomor_registrasi');
        return view('kelola_data.sertifikasi_dosen.input', compact('all_pegawai', 'all_sertifikasi'));
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            DB::beginTransaction();

            $validated = $this->validation($request);

            $sertifikat_cek_exist = SertifikasiDosen::where('nomor_registrasi', $request->nomor_registrasi)->first();

            $sertifikasi = null;
            $from = false;
            if (!$sertifikat_cek_exist) {
                // dd('masuk aman');
                $sertifikasi = SertifikasiDosen::create($validated);
                // dd($sertifikasi,$sertifikasi->id);
                $request['sertifikasi_id'] = $sertifikasi->id;
                $from = true;
            } else if ($request->sertifikat_id) {
                $sertifikasi = SertifikasiDosen::where('id', $request->sertifikat_id)->first();
                $request['sertifikasi_id'] = $sertifikasi->id;
            } else {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput() // Ini untuk mengembalikan input form (seperti nama, tgl, dll)
                    ->with('id_sertif_exist', $sertifikat_cek_exist->id) // Simpan ID di session
                    ->withErrors([
                        'exist_sertif' => 'Nomor sertifikat sudah terdaftar: ' . $sertifikat_cek_exist->nomor_registrasi
                    ]);
            }



            // if ($request->has('dosen_id_group')) {
            //     foreach ($request->dosen_id_group as $dosen_one) {
            //         $tosave  = new Request([
            //             'dosen_id' =>  $dosen_one,
            //             'sertifikasi_id' => $request->sertifikasi_id,
            //         ]);
            //         $dosen = (new SertifikasiOwnerController())->create($tosave);
            //         if ($dosen->getStatusCode() != 200 && $dosen->getStatusCode() !== 201) {
            //             $respons_error = $dosen->getData();
            //             throw new \Exception($respons_error->error);
            //         }
            //     }
            // } else {
            //     $tosave  = Request::create('', 'POST', [
            //         'dosen_id' => $request->dosen_id_single,
            //         'sertifikasi_id' => $request->sertifikasi_id,
            //     ]);
            //     $dosen = (new SertifikasiOwnerController())->create($tosave);

            //     if ($dosen->getStatusCode() != 200 && $dosen->getStatusCode() !== 201) {
            //         $respons_error = $dosen->getData();
            //         throw new \Exception($respons_error->error);
            //     }
            // }



            // save file sertifikasi
            // dd($request->hasFile('sertifikat_id'), $request->file('file_sertifikat'));
            if ((!$request->has('sertifikat_id')) & $request->has('file_sertifikat')) {
                $file_to_save = $validated['file_sertifikat'];
                $save = $file_to_save->storeAs(
                    'SERDOS',
                    trim(str_replace(' ', '-', $sertifikasi->id)) . '.' . $request->file('file_sertifikat')->getClientOriginalExtension(),
                    'public'
                );
                // dd($save,'save');
                if ($save) {
                    // dd();
                    $update_sertifikasi = SertifikasiDosen::where('id', $sertifikasi->id)->first();
                    $update_sertifikasi->path = 'SERDOS/' . trim(str_replace(' ', '-', $sertifikasi->id)) . '.' . $request->file('file_sertifikat')->getClientOriginalExtension();
                    if ($update_sertifikasi->save()) {
                        // dd('amaan');
                    }
                    // DD($update_sertifikasi->path==$save, $save,$update_sertifikasi->path);
                }

                if (!$save) {
                    throw new \Exception('Gagal Menyimpan File Sertifikasi');
                }
            }

            DB::commit();
            DD('CEM');
            return redirect()
                ->route('manage.sertifikasi-dosen.list')
                ->with('success', 'Data sertifikasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }



    public function edit($id)
    {
        $sertifikasi = SertifikasiDosen::findOrFail($id);
        $dosens = Dosen::with('pegawai')->get();
        return view('kelola_data.sertifikasi_dosen.edit', compact('sertifikasi', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $sertifikasi = SertifikasiDosen::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|uuid|exists:dosens,id|unique:sertifikasis,dosen_id,' . $id,
            'nomor_registrasi' => 'nullable|string|max:50|unique:sertifikasis,nomor_registrasi,' . $id,
            'no_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date',
        ]);

        $sertifikasi->update($validated);

        return redirect()->route('manage.sertifikasi-dosen.list')->with('success', 'Data sertifikasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sertifikasi = SertifikasiDosen::findOrFail($id);
        $sertifikasi->delete();

        return redirect()->route('manage.sertifikasi-dosen.list')->with('success', 'Data sertifikasi berhasil dihapus');
    }

    public function view($id)
    {
        $sertifikasi = SertifikasiDosen::with(['dosen.pegawai', 'dosen.prodi'])->findOrFail($id);
        return view('kelola_data.sertifikasi_dosen.view', compact('sertifikasi'));
    }

    public function upload()
    {
        return view('kelola_data.sertifikasi_dosen.upload');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        return redirect()->route('manage.sertifikasi-dosen.list')->with('success', 'File berhasil diupload');
    }

    public function bpmn()
    {
        if (session('account')['is_admin'] == 1) {
            $path = public_path('/BPMN/BPMN Sertifikasi Dosen.png');
            return response()->file($path);
        } else {
            abort(404, "Anda Tidak Memiliki Akses atau file tidak ditemukan");
        }
    }
    public function serdos_file($id_serdos)
    {
        $serdos_data = SertifikasiDosen::where('sertifikasis.id', $id_serdos)
            ->join('dosens', 'dosens.id', '=', 'sertifikasis.dosen_id')
            ->join('users', 'users.id', '=', 'dosens.users_id')
            ->select('users.id as user_id', 'sertifikasis.path as path')
            ->first();
        // dd($serdos_data->path,$serdos_data['path'],$serdos_data);
        if (session('account')['is_admin'] == 1 || ($serdos_data && $serdos_data->user_id == session('account')['id'])) {

            if (!$serdos_data) {
                return redirect()->back()->with('error_alert', 'Sertifikasi Dosen Tidak Terdaftar');
            }

            if ($serdos_data->path == null) {
                return redirect()->back()->with('error_alert', 'Berkas tidak ditemukan. File mungkin telah dihapus atau sedang mengalami gangguan.');
            }
            $path = storage_path('app/public/' . $serdos_data->path);
            return response()->file($path);
        } else {
            abort(404, "Anda Tidak Memiliki Akses atau file tidak ditemukan");
        }
    }


    public function validation(Request $request)
    {
        return $validated = $request->validate([
            // 'input_type'          => ['required', 'in:mandiri,kelompok'],

            // Logika Dosen
            'dosen_id'     => ['required_if:input_type,mandiri', 'nullable'],
            // 'dosen_id_group'      => ['required_if:input_type,kelompok', 'nullable', 'array', 'min:1'],

            // Logika Utama: Pilih vs Input Baru
            // 'sertifikat_id'       => ['nullable', 'required_without:file_sertifikat'],
            'file_sertifikat'     => ['nullable',  'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],

            // Field detail hanya wajib jika user memilih jalur 'Input Baru' (file_sertifikat diisi / sertifikat_id kosong)
            'nomor_registrasi'    => ['nullable', 'string', 'max:255'],
            'judul'               => ['nullable', 'string', 'max:500'],
            // 'tipe_sertifikasi'    => [ 'nullable', 'string'],
            // 'pelaksanaan'         => ['nullable', 'in:Offline,Online'],
            // 'biaya_pelatihan'     => ['nullable', 'numeric', 'min:0'],
            'tmt_mulai'   => ['nullable', 'date'],
            'tmt_akhir' => ['nullable', 'date', 'after_or_equal:tgl_berlaku_mulai'],
            // 'tgl_pelaksana'       => [ 'nullable', 'date'],
            'tgl_sertifikasi'     => ['nullable', 'date'],

        ], [
            'required'              => ':attribute wajib diisi.',
            'required_if'           => ':attribute wajib diisi jika tipe input adalah :value.',
            'required_without'      => ':attribute wajib diisi jika tidak memilih sertifikat yang sudah ada.',
            'date'                  => ':attribute harus berupa tanggal yang valid.',
            'after_or_equal'        => ':attribute tidak boleh sebelum :date.',
        ], [
            'input_type'          => 'Tipe Input (Kelompok/Mandiri)',
            'dosen_id'     => 'Dosen',
            // 'dosen_id_group'      => 'Dosen Kelompok',
            // 'sertifikat_id'       => 'Pilihan Sertifikat',
            'file_sertifikat'     => 'File Sertifikat',
            'nomor_registrasi'    => 'Nomor Registrasi',
            'judul'               => 'Judul Sertifikasi',
            // 'tipe_sertifikasi'    => 'Tipe Sertifikasi',
            // 'pelaksanaan'         => 'Metode Pelaksanaan',
            // 'biaya_pelatihan'     => 'Biaya Pelatihan',
            'tgl_berlaku_mulai'   => 'Tanggal Mulai Berlaku',
            'tgl_berlaku_selesai' => 'Tanggal Selesai Berlaku',
            // 'tgl_pelaksana'       => 'Tanggal Pelaksanaan',
            'tgl_sertifikasi'     => 'Tanggal Sertifikasi',
        ]);
    }
}
