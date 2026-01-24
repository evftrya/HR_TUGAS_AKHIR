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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index($destination)
    {
        $text = ucwords(strtolower($destination));
        // dd($text);
        if (!in_array($text, ['Active', 'Nonactive', 'Semua'])) {
            return redirect('/manage/pegawai/list/All');
        } else {
            $users = User::all();
            if ($destination != 'Semua') {
                if ($destination == 'Active') {
                    $users = $users->where('is_active', 1);
                } else {
                    $users = $users->where('is_active', 0);
                }
            }
            foreach ($users as $user) {
                $user['bagian'] = null;
                $user['kode'] = null;
                // $user['kode_bagian']=null;
                $nip = RiwayatNip::where('users_id', $user->id)->first();
                $user['nip'] = $nip == null ? '-' : $nip->nip;
                // dd($user);


                // // dd($tes);
                // $user['bagian'] = work_position::where('id',$user['work_position_id'])->first()->position_name;
                // $user['bagian'] = work_position::where('id',$user['work_position_id'])->first()->singkatan;
                if ($user['tipe_pegawai'] === 'Dosen') {
                    // dd($user);
                    $bagian = work_position::where('id', Dosen::where('users_id', $user['id'])->first()->prodi_id)->first();
                    $user['bagian'] = $bagian;
                } else {
                    $bagian = work_position::where('id', Tpa::where('users_id', $user['id'])->first()->bagian_id)->first();
                    $user['bagian'] = $bagian;
                    // dd($user['bagian']->kode);
                }
            }

            $send = [$text];
            // dd(Fakultas::alll());

            // dd($users);
            return view('kelola_data.pegawai.list', compact('send', 'users'));
        }
    }

    public function new()
    {
        $jenjang_pendidikan_options = refJenjangPendidikan::all();
        $status_pegawai_options = RefStatusPegawai::all();;
        $jenjang_jfa_options = RefPangkatGolongan::all();
        $send = null;
        return view('kelola_data.pegawai.input', compact('send', 'jenjang_pendidikan_options', 'status_pegawai_options', 'jenjang_jfa_options'));
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
            $validated['password'] = strtolower(str_replace(' ', '', $validated['telepon'] . '&' . $validated['nama_lengkap']));
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
                foreach ($request['emergency_contacts'] as $save) {
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
        $user = (new ProfileController)->based_user_data($idUser);
        dd($user);
        // $send = [$idUser];
        return view('kelola_data.pegawai.change-password', compact('user'));
    }

    public function updatePassword(Request $request, $idUser)
    {
        $validated = $request->validate(
            [
                'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            ],
            [
                'password.required' => 'Password baru wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password baru minimal :min karakter.',
            ]
        );



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

    /**
     * Display dashboard with statistics
     */
    public function dashboard()
    {
        $stats = [
            'total' => User::count(),
            'dosen' => User::where('tipe_pegawai', 'Dosen')->count(),
            'tpa' => User::where('tipe_pegawai', 'TPA')->count(),
            'active' => User::where('is_active', 1)->count(),
            'male' => User::where('jenis_kelamin', 'Laki-laki')->count(),
            'female' => User::where('jenis_kelamin', 'Perempuan')->count(),
        ];

        $recentEmployees = User::orderBy('created_at', 'desc')->take(10)->get();

        return view('kelola_data.pegawai.dashboard', compact('stats', 'recentEmployees'));
    }

    public function importAdd()
    {
        return view('kelola_data.pegawai.import.import');
    }

    public function importValidateFile(Request $req)
    {
        $validated = $req->validate([
            'file' => [
                'required',
                'file',
                'max:10280', // 25MB (KB)
                // Excel / CSV / JSON
                'mimes:xlsx,xls,csv,json',
            ],
        ], [
            'file.required' => 'Pilih file terlebih dahulu.',
            'file.file'     => 'Upload harus berupa file.',
            'file.max'      => 'Ukuran file melebihi 25 MB.',
            'file.mimes'    => 'Format file tidak diizinkan. Gunakan: xlsx, xls, csv, atau json.',
        ]);

        // lanjut proses import...
        // $file = $request->file('file');
        $file = $req->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $this->convertAllRow($sheet->toArray(null, true, true, true));

        return view('kelola_data.pegawai.import.preview-data', ['data' => $rows]);
    }

    public function convertAllRow($data)
    {
        $out = [];

        foreach ($data as $index => $row) {
            if ($index === 1) continue; // skip header excel
            $out[] = $this->convertRow($row);
        }

        return $out;
    }

    public function convertRow($data)
    {
        $out = [];
        $ref = $this->colToField();
        foreach ($ref as $col => $field) {
            $out[$field] = $data[$col] ?? null;
        }
        return $out;

        dd($out);

        return $out;
    }

    public function colToField()
    {
        $colToField = [
            // Data utama pegawai
            'A'  => 'nama_lengkap',
            'B'  => 'nik',
            'C'  => 'username',
            'D'  => 'telepon',
            'E'  => 'email_pribadi',
            'F'  => 'email_institusi',
            'G'  => 'telepon_darurat',
            'H'  => 'jenis_kelamin',
            'I'  => 'alamat',
            'J'  => 'tempat_lahir',
            'K'  => 'tgl_lahir',
            'L'  => 'tipe_pegawai',
            'M'  => 'status_kepegawaian',
            'N'  => 'nip',
            'O'  => 'tmt_mulai',

            // Emergency Contact 1
            'P'  => 'ec1_status_hubungan',
            'Q'  => 'ec1_nama_lengkap',
            'R'  => 'ec1_telepon',
            'S'  => 'ec1_email',
            'T'  => 'ec1_alamat',

            // Emergency Contact 2
            'U'  => 'ec2_status_hubungan',
            'V'  => 'ec2_nama_lengkap',
            'W'  => 'ec2_telepon',
            'X'  => 'ec2_email',
            'Y'  => 'ec2_alamat',

            // Emergency Contact 3
            'Z'  => 'ec3_status_hubungan',
            'AA' => 'ec3_nama_lengkap',
            'AB' => 'ec3_telepon',
            'AC' => 'ec3_email',
            'AD' => 'ec3_alamat',

            // Emergency Contact 4
            'AE' => 'ec4_status_hubungan',
            'AF' => 'ec4_nama_lengkap',
            'AG' => 'ec4_telepon',
            'AH' => 'ec4_email',
            'AI' => 'ec4_alamat',
        ];

        return $colToField;
    }

    public function importSaveData(Request $request)
    {
        // 1) RULES DASAR (FIELD BERBINTANG)
        $rules = [
            'nama_lengkap'        => ['required', 'array'],
            'nama_lengkap.*'      => ['required', 'string'],

            'nik'                 => ['required', 'array'],
            'nik.*'               => ['required', 'string'],

            'username'            => ['required', 'array'],
            'username.*'          => ['required', 'string'],

            'telepon'             => ['required', 'array'],
            'telepon.*'           => ['required', 'string'],

            'email_pribadi'       => ['required', 'array'],
            'email_pribadi.*'     => ['required', 'email'],

            'email_institusi'     => ['required', 'array'],
            'email_institusi.*'   => ['required', 'email'],

            'telepon_darurat'     => ['required', 'array'],
            'telepon_darurat.*'   => ['required', 'string'],

            'jenis_kelamin'       => ['required', 'array'],
            'jenis_kelamin.*'     => ['required', 'in:Perempuan,Laki-laki'],

            'alamat'              => ['required', 'array'],
            'alamat.*'            => ['required', 'string'],

            'tempat_lahir'        => ['required', 'array'],
            'tempat_lahir.*'      => ['required', 'string'],

            'tgl_lahir'           => ['required', 'array'],
            'tgl_lahir.*'         => ['required', 'date'],

            'tipe_pegawai'        => ['required', 'array'],
            'tipe_pegawai.*'      => ['required', 'in:Dosen,TPA'],

            'status_kepegawaian'  => ['required', 'array'],
            'status_kepegawaian.*' => ['required', 'string'],

            'nip'                 => ['required', 'array'],
            'nip.*'               => ['required', 'string'],

            // tidak berbintang (opsional)
            'tmt_mulai'            => ['nullable', 'array'],
            'tmt_mulai.*'          => ['nullable', 'date'],
        ];

        // 2) RULES EMERGENCY CONTACT (ARRAY + CONDITIONAL PER INDEX)
        foreach ([1, 2, 3, 4] as $i) {
            $rules["ec{$i}_status_hubungan"] = ['nullable', 'array'];
            $rules["ec{$i}_status_hubungan.*"] = ['nullable', 'string'];

            $rules["ec{$i}_nama_lengkap"] = ['nullable', 'array'];
            $rules["ec{$i}_nama_lengkap.*"] = ['nullable', 'string'];

            $rules["ec{$i}_telepon"] = ['nullable', 'array'];
            $rules["ec{$i}_telepon.*"] = ['nullable', 'string'];

            $rules["ec{$i}_email"] = ['nullable', 'array'];
            $rules["ec{$i}_email.*"] = ['nullable', 'email'];

            $rules["ec{$i}_alamat"] = ['nullable', 'array'];
            $rules["ec{$i}_alamat.*"] = ['nullable', 'string'];
        }

        $validator = Validator::make($request->all(), $rules);

        // 3) VALIDASI LANJUTAN: PER ROW
        $validator->after(function ($v) use ($request) {
            $rows = count($request->input('nama_lengkap', []));

            for ($idx = 0; $idx < $rows; $idx++) {

                // --- A) RULE: jika status_hubungan ecX diisi, field lain wajib diisi ---
                foreach ([1, 2, 3, 4] as $i) {
                    $status = trim((string)($request->input("ec{$i}_status_hubungan.$idx") ?? ''));
                    $nama   = trim((string)($request->input("ec{$i}_nama_lengkap.$idx") ?? ''));
                    $telp   = trim((string)($request->input("ec{$i}_telepon.$idx") ?? ''));
                    $email  = trim((string)($request->input("ec{$i}_email.$idx") ?? ''));
                    $alamat = trim((string)($request->input("ec{$i}_alamat.$idx") ?? ''));

                    // kalau ada status => wajib lengkap
                    if ($status !== '') {
                        if ($nama === '')   $v->errors()->add("ec{$i}_nama_lengkap.$idx", "Row " . ($idx + 1) . ": EC{$i} Nama Lengkap wajib diisi jika Status Hubungan diisi.");
                        if ($telp === '')   $v->errors()->add("ec{$i}_telepon.$idx", "Row " . ($idx + 1) . ": EC{$i} Telepon wajib diisi jika Status Hubungan diisi.");
                        if ($email === '')  $v->errors()->add("ec{$i}_email.$idx", "Row " . ($idx + 1) . ": EC{$i} Email wajib diisi jika Status Hubungan diisi.");
                        if ($alamat === '') $v->errors()->add("ec{$i}_alamat.$idx", "Row " . ($idx + 1) . ": EC{$i} Alamat wajib diisi jika Status Hubungan diisi.");
                    }

                    // kalau field lain ada isinya tapi status kosong -> paksa isi status
                    $anyOtherFilled = ($nama !== '' || $telp !== '' || $email !== '' || $alamat !== '');
                    if ($status === '' && $anyOtherFilled) {
                        $v->errors()->add("ec{$i}_status_hubungan.$idx", "Row " . ($idx + 1) . ": EC{$i} Status Hubungan wajib diisi jika data EC{$i} lainnya diisi.");
                    }
                }

                // --- B) RULE: minimal 1 emergency contact per row ---
                $hasAtLeastOneEC = false;

                foreach ([1, 2, 3, 4] as $i) {
                    $status = trim((string)($request->input("ec{$i}_status_hubungan.$idx") ?? ''));
                    $nama   = trim((string)($request->input("ec{$i}_nama_lengkap.$idx") ?? ''));
                    $telp   = trim((string)($request->input("ec{$i}_telepon.$idx") ?? ''));
                    $email  = trim((string)($request->input("ec{$i}_email.$idx") ?? ''));
                    $alamat = trim((string)($request->input("ec{$i}_alamat.$idx") ?? ''));

                    // definisi "terisi" = status ada dan 4 field lain lengkap
                    if ($status !== '' && $nama !== '' && $telp !== '' && $email !== '' && $alamat !== '') {
                        $hasAtLeastOneEC = true;
                        break;
                    }
                }

                if (!$hasAtLeastOneEC) {
                    // taruh error ke ec1_status_hubungan biar gampang ditandai di UI
                    $v->errors()->add("ec1_status_hubungan.$idx", "Row " . ($idx + 1) . ": Minimal 1 Emergency Contact harus diisi lengkap (Status Hubungan, Nama, Telepon, Email, Alamat).");
                }
            }
        });

        $validated = $validator->validate();
        return 'aman';

        // ✅ kalau lolos, lanjut proses import...
        // dd($validated);

        // ... logic import kamu
    }
}
