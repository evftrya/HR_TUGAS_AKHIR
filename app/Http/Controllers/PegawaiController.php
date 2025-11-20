<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Emergency_contact;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\RefBagian;
use App\Models\refJabatanFungsionalAkademik;
use App\Models\refJenjangPendidikan;
use App\Models\RefPangkatGolongan;
use App\Models\RefStatusPegawai;
use App\Models\riwayatJabatanFungsionalAkademik;
use App\Models\riwayatJenjangPendidikan;
use App\Models\RiwayatNip;
use App\Models\Tpa;
use App\Models\work_position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index($destination)
    {
        $text = ucwords(strtolower($destination));
        // dd($text);
        if(!in_array($text, ['Active', 'Nonactive', 'Semua'])){
            return redirect('/manage/pegawai/list/All');
        }
        else{
            $users = User::all();
            if($destination!='Semua'){
                if($destination=='Active'){
                    $users = $users->where('is_active',1);
                }
                else{
                    $users = $users->where('is_active',0);
                }
            }
            foreach($users as $user){
                $user['bagian']=null;
                $user['kode']=null;
                // $user['kode_bagian']=null;
                $nip = RiwayatNip::where('users_id',$user->id)->first();
                $user['nip'] = $nip==null?'-':$nip->nip;
                // dd($user);
                
                
                // // dd($tes);
                // $user['bagian'] = work_position::where('id',$user['work_position_id'])->first()->position_name;
                // $user['bagian'] = work_position::where('id',$user['work_position_id'])->first()->singkatan;
                if($user['tipe_pegawai']==='Dosen'){
                    // dd($user);
                    $bagian = work_position::where('id',Dosen::where('users_id',$user['id'])->first()->prodi_id)->first();
                    $user['bagian'] = $bagian;
                }
                else{
                    $bagian = work_position::where('id',Tpa::where('users_id',$user['id'])->first()->bagian_id)->first();
                    $user['bagian'] = $bagian;
                    // dd($user['bagian']->kode);
                }
            }
            
            $send = [$text];
        // dd(Fakultas::alll());

            // dd($users);
            return view('kelola_data.pegawai.list',compact('send','users'));
        }
    }

    public function new()
    {
        $jenjang_pendidikan_options = refJenjangPendidikan::all();
        $status_pegawai_options = RefStatusPegawai::all();;
        $jenjang_jfa_options=RefPangkatGolongan::all();
        $send = null;
        return view('kelola_data.pegawai.input',compact('send','jenjang_pendidikan_options','status_pegawai_options','jenjang_jfa_options'));

    }


    public function create(Request $request)
    {
        // Jalankan validasi
        // dd(($request['emergency_contacts']));
        
        // tes
        // dd($request->status_kepegawaian, $request->jenjang_pendidikan_id);


        $tipe = strtolower((string) $request->input('tipe_pegawai'));

        $validated = $request->validate([
            // Data diri (umum)
            'nik'                  => ['nullable', 'string', 'max:20'],
            'nama_lengkap'        => ['required', 'string', 'max:100'],
            'username'            => ['required', 'alpha_dash', 'min:3', 'max:20'],
            'telepon'             => ['nullable', 'regex:/^0\d{9,12}$/'],
            // 'emergency_contact_phone' => ['nullable', 'regex:/^0\d{9,12}$/'],
            'alamat'              => ['nullable', 'string', 'max:300'],

            'email_pribadi'       => ['nullable', 'email:rfc,dns', 'max:150'],
            'email_institusi'     => ['nullable', 'email:rfc,dns', 'max:150'],

            'jenis_kelamin'       => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'tempat_lahir'        => ['nullable', 'string', 'max:100'],
            'tgl_lahir'           => ['nullable', 'date', 'before:today'],

            // Tipe & status kepegawaian
            'tipe_pegawai'        => ['required', Rule::in(['Dosen', 'TPA'])],
            'tmt_mulai'       => ['nullable', 'date', 'after:tgl_lahir'],
            'status_kepegawaian'  => 'required',
            'nip'                  => ['nullable', 'string', 'max:30'], 

            // Data kepegawaian khusus per tipe
            // 'nidn'  => ['nullable','string','max:20', Rule::requiredIf($tipe === 'dosen')],
            // 'nuptk' => ['nullable','string','max:20', Rule::requiredIf($tipe === 'dosen')],
            // 'jfa'   => ['nullable', Rule::requiredIf($tipe === 'dosen')],

            // Wajib saat TPA, boleh kosong selain itu
            // 'nitk'  => ['nullable','string','max:15', Rule::requiredIf($tipe === 'tpa')],

            // Data pendidikan
            // 'jenjang_pendidikan_id'   => 'required',
            // 'bidang_pendidikan'    => ['nullable', 'string', 'max:150'],
            // 'jurusan'              => ['nullable', 'string', 'max:150'],
            // 'nama_kampus'          => ['nullable', 'string', 'max:150'],
            // 'alamat_kampus'        => ['nullable', 'string', 'max:150'],

            // 'tahun_lulus'          => ['nullable', 'integer', 'digits:4', 'between:1900,' . now()->year],
            // 'nilai'                => ['nullable', 'numeric', 'min:0', 'max:4'],
            // 'gelar'                => ['nullable', 'string', 'max:50'],
            // 'singkatan_gelar'      => ['nullable', 'string', 'max:20'],

            // 'ijazah_file'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            // Pesan error umum
            'required' => ':attribute wajib diisi.',
            'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'max' => ':attribute maksimal :max karakter.',
            'min' => ':attribute minimal :min karakter.',
            'email' => 'Format :attribute tidak valid.',
            'in' => ':attribute tidak valid.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'before' => ':attribute harus sebelum hari ini.',
            'after' => ':attribute harus setelah :date.',
            'numeric' => ':attribute harus berupa angka.',
            'integer' => ':attribute harus berupa angka bulat.',
            'digits' => ':attribute harus terdiri dari :digits digit.',
            'between' => ':attribute harus antara :min dan :max.',
            'regex' => 'Format :attribute tidak valid.',
            'file' => ':attribute harus berupa file.',
            'mimes' => ':attribute harus berformat: :values.',
            'max.file' => ':attribute maksimal :max kilobyte.',

            // Pesan khusus
            'telepon.regex' => 'Nomor telepon harus diawali 0 dan berjumlah 10–13 digit.',
            'emergency_contact_phone.regex' => 'Nomor telepon darurat harus diawali 0 dan berjumlah 10–13 digit.',
            // 'nidn.required' => 'NIDN wajib diisi untuk Dosen.',
            'nomor_induk_pegawai.required' => 'Nomor Induk Pegawai/NUPTK wajib diisi untuk Dosen.',
            // 'jfa.required' => 'JFA wajib dipilih untuk Dosen.',
            // 'nitk.required' => 'NITK wajib diisi untuk TPA.',
        ]);



        try {
            DB::beginTransaction();
            // password default: telepon&namalengkap (tanpa spasi)
            $validated['password'] = strtolower(str_replace(' ', '', $validated['telepon'].'&'.$validated['nama_lengkap']));
            $validated['tgl_bergabung'] = $validated['tmt_mulai'];
            $validated['status_pegawai_id'] = $validated['status_kepegawaian'];

            // Create User
            $validated['users_id'] = null;
            try {
                $user = User::create($validated);
                $validated['users_id'] = $user->id;

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat User',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Create Riwayat NIP
            try {
                $status_pegawai = RiwayatNip::create($validated);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat Riwayat NIP',
                    'error' => $e->getMessage()
                ], 500);
            }

            try {
                $status_pegawai = RiwayatNip::create($validated);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat Riwayat NIP',
                    'error' => $e->getMessage()
                ], 500);
            }
            // dd($request['emergency_contacts']);

            try {
                foreach($request['emergency_contacts'] as $save){
                    $save['users_id'] = $user->id;
                    Emergency_contact::create($save);

                    // dd($save);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat Emergency Contact',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Create Riwayat Pendidikan
            // try {
            //     $pendidikan = RiwayatJenjangPendidikan::create($validated);
            // } catch (\Exception $e) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Gagal membuat Riwayat Pendidikan',
            //         'error' => $e->getMessage()
            //     ], 500);
            // }

            // Create Data Pegawai Berdasarkan Tipe
            try {
                if ($validated['tipe_pegawai'] == 'Dosen') {
                    $pegawai = Dosen::create($validated);
                } else {
                    $pegawai = Tpa::create($validated);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat data pegawai',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Jika semua berhasil
            DB::commit();

            return redirect(route('manage.pegawai.view.personal-info', ['idUser' => $validated['users_id']]))->with('success', 'Data pegawai berhasil disimpan!');


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan tidak terduga',
                'error' => $e->getMessage()
            ], 500);
        }


        // return redirect(route('manage.pegawai.list', ['destination' => 'All']));

        // dd($request,$request->file('ijazah_file'));


        // return back()->with('success', 'Data pegawai berhasil disimpan!');
    }

    public function changePassword($idUser)
    {
        $user = User::find($idUser);
        // $send = [$idUser];
        return view('kelola_data.pegawai.change-password',compact('user'));
    }

    public function updatePassword(Request $request,$idUser)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ],
        [
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password baru minimal :min karakter.',
        ]);



        $user = User::find($idUser);
        $user->password = $validated['password'];
        $user->save();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Password berhasil diperbarui!'
        // ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    public function setNonactive(Request $request, $idUser)
    {
        $user = User::find($idUser);
        $user->is_active = false;
        $user->save();

        return redirect()->back()->with('success', 'Akun pegawai berhasil dinonaktifkan!');
    }

    public function setActive(Request $request, $idUser)
    {
        $user = User::find($idUser);
        $user->is_active = true;
        $user->save();

        return redirect()->back()->with('success', 'Akun pegawai berhasil diaktifkan!');
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $users)
    {
        //
    }
}
