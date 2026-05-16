<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\SertifikasiDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SertifikasiDosenController extends Controller
{
    public string $aksi = 'Sertifikasi Dosen';

    public function index()
    {
        // dd(session('account')['role']);
        // DT

        // admin only
        if ($this->isAdminOrSdm()) {
            $sertifikasi = SertifikasiDosen::all();
        } else {
            $sertifikasi = SertifikasiDosen::where('dosen_id', Dosen::where('users_id', session('account')['id'])->first()['id'])->get();
        }

        return view('kelola_data.sertifikasi_dosen.list', compact('sertifikasi'));
    }

    public function create()
    {
        // DT

        // dosen only
        if ($this->isAdminOrSdm()) {

            $all_pegawai = Dosen::select('dosens.*')
                ->join('users', 'users.id', '=', 'dosens.users_id')
                ->where('users.is_active', 1)
                ->orderBy('users.tipe_pegawai', 'desc')
                ->orderBy('users.nama_lengkap', 'asc')
                ->with('pegawai_aktif') // optional, kalau masih butuh relasi
                ->get();
        } else {
            $all_pegawai = Dosen::select('dosens.*')
                ->join('users', 'users.id', '=', 'dosens.users_id')
                ->where('users.is_active', 1)
                ->where('dosens.users_id', session('account')['id'])
                ->orderBy('users.tipe_pegawai', 'desc')
                ->orderBy('users.nama_lengkap', 'asc')
                ->with('pegawai_aktif') // optional, kalau masih butuh relasi
                ->get();
        }
        // dD($all_pegawai, $all_pegawai[0]->pegawai_aktif);
        $all_sertifikasi = SertifikasiDosen::all()->sortBy('nomor_registrasi');

        return view('kelola_data.sertifikasi_dosen.input', compact('all_pegawai', 'all_sertifikasi'));

    }

    public function store(Request $request)
    {
        $validation = $this->validation();
        $validated = $request->validate($validation[0], $validation[1], $validation[2]);
        try {
            DB::beginTransaction();

            // $user_id = Dosen::with('pegawai')->first()['id'];
            $dosen_user = Dosen::where('id', $validated['dosen_id'])->first();
            if (! $dosen_user) {
                throw new \Exception('Dosen Tidak Ditemukan!.');
            }
            // $user_id = Dosen::with('pegawai')->where('id',$dosen_user['users_id'])->first()['id'];
            // dd($use)
            if (!$this->onlyOwnerAdminAndSdm($dosen_user['users_id'])) {
                // dd('zjsgdjaz');
                // return $this->handleRedirectBack()->with('error_alert', 'Anda Tidak Memiliki Akses untuk melakukan perubahan data maupun penambahan data pada segala data Sertifikasi Dosen selain milik anda!.');
                // return redirect()->back()->with('error_alert', 'Anda Tidak Memiliki Akses untuk melakukan perubahan data maupun penambahan data pada segala data Sertifikasi Dosen selain milik anda!.');
                return redirect()->back()->with('error_alert','Anda Tidak Memiliki Akses untuk melakukan perubahan data maupun penambahan data pada segala data Sertifikasi Dosen selain milik anda!.');

            }
        // dd('sjkdnas');




            $sertifikat_cek_exist = SertifikasiDosen::where('nomor_registrasi', $request->nomor_registrasi)->first();

            $sertifikasi = null;
            $from = false;
            // $cek_dosen =

            if (! $sertifikat_cek_exist) {
                // dd('masuk aman');
                $sertifikasi = SertifikasiDosen::create($validated);
                // dd($sertifikasi,$sertifikasi->id);
                $request['sertifikasi_id'] = $sertifikasi->id;
                $from = true;
            } elseif ($request->sertifikat_id) {
                $sertifikasi = SertifikasiDosen::where('id', $request->sertifikat_id)->first();
                $request['sertifikasi_id'] = $sertifikasi->id;
            } else {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->withInput($validated) // Ini untuk mengembalikan input form (seperti nama, tgl, dll)
                    ->with('id_sertif_exist', $sertifikat_cek_exist->id) // Simpan ID di session
                    ->withErrors([
                        'exist_sertif' => 'Nomor sertifikat sudah terdaftar: '.$sertifikat_cek_exist->nomor_registrasi,
                    ]);
            }
            if ((! $request->has('sertifikat_id')) & $request->has('file_sertifikat')) {
                $file_to_save = $validated['file_sertifikat'];
                $save = $file_to_save->storeAs(
                    'SERDOS',
                    trim(str_replace(' ', '-', $sertifikasi->id)).'.'.$request->file('file_sertifikat')->getClientOriginalExtension(),
                    'public'
                );
                // dd($save,'save');
                if ($save) {
                    // dd();
                    $update_sertifikasi = SertifikasiDosen::where('id', $sertifikasi->id)->first();
                    $update_sertifikasi->path = 'SERDOS/'.trim(str_replace(' ', '-', $sertifikasi->id)).'.'.$request->file('file_sertifikat')->getClientOriginalExtension();
                    // dd($update_sertifikasi->path, 'tes');
                    if (! $update_sertifikasi->save()) {
                        throw new \Exception('Gagal Menyimpan Data File Sertifikasi');
                    }
                }
                if (! $save) {
                    throw new \Exception('Gagal Menyimpan File Sertifikasi');
                }
            }
            DB::commit();
            // DD('CEM');
            // dd($sertifikasi);
            $route = redirect(route('profile.personal-info', ['idUser' => $dosen_user->users_id]))->with('success', 'Berhasil menambahkan data sertifikasi dosen ini.');

            return $this->CekReview($route, '1H1', 'MENAMBAH DATA SERTIFIKASI DOSEN');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput($validated)
                ->withErrors([
                    'error' => 'Terjadi kesalahan: '.$e->getMessage(),
                ])->with('error_alert', 'Gagal Menyimpan!.'.$e->getMessage());
        }

    }

    public function edit($id)
    {
        try {

            // dosen only

            $sertifikasi = null;

            try {
                $sertifikasi = SertifikasiDosen::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Sertifikasi ini tidak terdaftar!.');
            }


            $user_id = Dosen::with('pegawai')->where('id',$sertifikasi->dosen_id)->first()['users_id'];
            // dd($user_id, session('account')['id'], 'id sertif:'.$id, 'dosen id: '.$sertifikasi->dosen_id);
            if ($this->onlyOwnerAdminAndSdm($user_id)) {
                $all_pegawai = Dosen::select('dosens.*')
                    ->join('users', 'users.id', '=', 'dosens.users_id')
                    ->where('users.is_active', 1)
                    ->orderBy('users.tipe_pegawai', 'desc')
                    ->orderBy('users.nama_lengkap', 'asc')
                    ->with('pegawai_aktif') // optional, kalau masih butuh relasi
                    ->get();
                // dD($all_pegawai, $all_pegawai[0]->pegawai_aktif);
                $all_sertifikasi = SertifikasiDosen::all()->sortBy('nomor_registrasi');
                $route = view('kelola_data.sertifikasi_dosen.edit', compact('all_pegawai', 'all_sertifikasi', 'sertifikasi'));

                return $this->CekReview($route, '1H3', 'MELIHAT LIST DATA SERTIFIKASI DOSEN');

            } else {
                return $this->handleRedirectBack()->with('error_alert', 'Anda Tidak Memiliki Akses untuk melakukan perubahan data maupun penambahan data pada segala data Sertifikasi Dosen selain milik anda!.');
            }
        } catch (\Exception $e) {
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $sertifikasi = null;
        try {
            $sertifikasi = SertifikasiDosen::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->handleRedirectBack()->with('error_alert','Sertifikasi ini tidak terdaftar!.');
        }

        $user_id = Dosen::with('pegawai')->where('id', $sertifikasi->dosen_id)->first()['users_id'];
        // dd($this->onlyOwnerAdminAndSdm($user_id), session('account')['id']);
        if ($this->onlyOwnerAdminAndSdm($user_id)) {
            try {


                $validation = $this->validation($id);
                $validated = $request->validate($validation[0], $validation[1], $validation[2]);

                DB::beginTransaction();
                $sertifikasi->update($validated);
                DB::commit();

                $route = redirect()->route('manage.sertifikasi-dosen.list')->with('success', 'Data sertifikasi berhasil diperbarui');

                return $this->CekReview($route, '1H4', 'MENGUBAH DATA SERTIFIKASI DOSEN');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->MakeLog('User Gagal Mengubah Data '.$this->aksi, ['alasan' => $e->getMessage()]);

                return $this->handleRedirectBack()
                    ->withInput($request->all())
                    ->withErrors(['system_error' => $e->getMessage()]);
            }
        } else {
            return $this->handleRedirectBack()->with('error_alert', 'Anda Tidak Memiliki Akses untuk melakukan perubahan data maupun penambahan data pada segala data Sertifikasi Dosen selain milik anda!.');
        }

    }

    public function destroy($id)
    {
        //     // dosen only tp ini ga kepake
        $sertifikasi = null;

        try {
            $sertifikasi = SertifikasiDosen::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new \Exception('Sertifikasi ini tidak terdaftar!.');
        }
        $sertifikasi->delete();

        return redirect()->route('manage.sertifikasi-dosen.list')->with('success', 'Data sertifikasi berhasil dihapus');
    }

    public function view($id)
    {
        // $sertifikasi = null;
        $sertifikasi = SertifikasiDosen::with(['dosen.pegawai', 'dosen.prodi'])->where('id', $id)->first();
        if (! $sertifikasi) {
            return $this->handleRedirectBack()->with('error_alert', 'Sertifikasi ini tidak terdaftar!.');
        }
        // dd('zksudhaks');
        // dd($this->onlyOwnerAdminAndSdm($sertifikasi->dosen->pegawai->id), session('account'),$sertifikasi);
        if (!$this->onlyOwnerAdminAndSdm($sertifikasi->dosen->pegawai->id)) {
            return $this->handleRedirectBack()->with('error_alert', 'Anda Tidak Memiliki Akses Untuk melihat halaman ini!.');
        }

        // DD($sertifikasi);
        return view('kelola_data.sertifikasi_dosen.view', compact('sertifikasi'));
    }

    // public function upload()
    // {
    //     // dosen only tp ini ga kepake
    //     return view('kelola_data.sertifikasi_dosen.upload');
    // }

    // public function processUpload(Request $request)
    // {
    //     // dosen only tp ini ga kepake

    //     $request->validate([
    //         'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
    //     ]);

    //     return redirect()->route('manage.sertifikasi-dosen.list')->with('success', 'File berhasil diupload');
    // }

    public function serdos_file($id_serdos)
    {
        // DT

        // dosen & admin
        $serdos_data = SertifikasiDosen::where('sertifikasis.id', $id_serdos)
            ->join('dosens', 'dosens.id', '=', 'sertifikasis.dosen_id')
            ->join('users', 'users.id', '=', 'dosens.users_id')
            ->select('users.id as user_id', 'sertifikasis.path as path')
            ->first();
        // dd($serdos_data->path,$serdos_data['path'],$serdos_data);
        if (session('account')['is_admin'] == 1 || ($serdos_data && $serdos_data->user_id == session('account')['id'])) {

            if (! $serdos_data) {
                return $this->handleRedirectBack()->with('error_alert', 'Sertifikasi Dosen Tidak Terdaftar');
            }

            if ($serdos_data->path == null) {
                return $this->handleRedirectBack()->with('error_alert', 'Berkas tidak ditemukan. File mungkin telah dihapus atau sedang mengalami gangguan.');
            }
            $path = storage_path('app/public/'.$serdos_data->path);

            return response()->file($path);
        } else {
            abort(404, 'Anda Tidak Memiliki Akses atau file tidak ditemukan');
        }
    }

    public function validation($id = null)
    {
        $id = $id == null ? '' : ','.$id;

        return [
            [
                'dosen_id' => ['required', 'exists:dosens,id'],
                'file_sertifikat' => [$id==null?'required':'nullable',  'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
                'nomor_registrasi' => ['nullable', 'string', 'max:100', 'unique:sertifikasis,nomor_registrasi'.$id],
                'judul' => ['nullable', 'string', 'max:100'],
                'tmt_mulai' => ['nullable', 'date'],
                'tmt_akhir' => ['nullable', 'date', 'after_or_equal:tgl_berlaku_mulai'],
                'tgl_sertifikasi' => ['nullable', 'date'],

            ], [
                'required' => ':attribute wajib diisi.',
                'required_if' => ':attribute wajib diisi jika tipe input adalah :value.',
                'required_without' => ':attribute wajib diisi jika tidak memilih sertifikat yang sudah ada.',
                'date' => ':attribute harus berupa tanggal yang valid.',
                'after_or_equal' => ':attribute tidak boleh sebelum :date.',
            ], [
                'input_type' => 'Tipe Input (Kelompok/Mandiri)',
                'dosen_id' => 'Dosen',
                'file_sertifikat' => 'File Sertifikat',
                'nomor_registrasi' => 'Nomor Registrasi',
                'judul' => 'Judul Sertifikasi',
                'tgl_berlaku_mulai' => 'Tanggal Mulai Berlaku',
                'tgl_berlaku_selesai' => 'Tanggal Selesai Berlaku',
                'tgl_sertifikasi' => 'Tanggal Sertifikasi',
            ],
        ];
    }

    public function view_file($id)
    {
        if ($this->onlyOwnerAdminAndSdm($id) == true) {
            $sk = SertifikasiDosen::where('id', $id)->first();

            if (! $sk) {
                abort(404, 'File tidak ditemukan');
            }
            // dd($sk, ($sk->file_sk == $file_path));
            $storagePath = storage_path('app/public/'.explode('_', $sk->file_sk)[0].'/'.$sk->path);

            if (file_exists($storagePath)) {
                $path = $storagePath;
            } else {
                // dd('masuk');
                abort(404, "File tidak ditemukan: $storagePath");
            }

            return response()->file($path);
        } else {
            return $this->handleRedirectBack()->with('error_alert', 'Anda Tidak Memiliki Akses untuk melakukan perubahan data maupun penambahan data pada segala data Sertifikasi Dosen selain milik anda!.');
        }
    }
}
