<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorParser;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Emergency_contact;
use App\Models\Fakultas;
use App\Models\formation;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Cache;

class PegawaiController extends Controller
{
    /**
     * Helper internal untuk membersihkan semua cache terkait data pegawai.
     * Membersihkan cache list per page dan cache statistik.
     */
    private function clearPegawaiCache()
    {
        // Jika menggunakan driver redis/memcached, idealnya menggunakan tags.
        // Namun untuk compatibility umum, kita hapus key-key utama.
        // Karena pagination menggunakan key dinamis, kita biarkan expire atau 
        // jika ingin ekstrim bisa menggunakan Cache::flush() namun ini menghapus semua cache aplikasi.

        Cache::forget('pegawai_stats');
        Cache::forget('pegawai_list_active_p1');
        Cache::forget('pegawai_list_nonactive_p1');
        Cache::forget('pegawai_list_semua_p1');

        // Menghapus cache input options jika ada perubahan pada tabel referensi
        Cache::forget('pegawai_input_options');
    }

    /**
     * Display a listing of the resource.
     * Menggunakan pengecekan ketat untuk mencegah Infinite Redirect Loop.
     */
    public function index($destination)
    {
        // 1. Normalisasi input agar konsisten (Active, Nonactive, Semua)
        $target = ucfirst(strtolower($destination));
        $validTargets = ['Active', 'Nonactive', 'Semua'];

        // 2. Cegah Redirect Loop: Hanya redirect jika input benar-benar di luar kategori
        if (!in_array($target, $validTargets)) {
            return redirect('/manage/pegawai/list/Semua');
        }

        // 3. Jika input valid tapi casing-nya salah (misal 'active'), redirect ke yang benar satu kali
        if ($destination !== $target) {
            return redirect('/manage/pegawai/list/' . $target);
        }

        $page = request()->query('page', 1);
        // Cache key unik per kategori dan per halaman
        $cacheKey = 'pegawai_list_' . strtolower($target) . '_p' . $page;

        $users = Cache::remember($cacheKey, 3600, function () use ($target) {
            $query = \App\Models\User::query()
                ->select([
                    'users.*',
                    'rn.nip as nip_aktif',
                    DB::raw('COALESCE(wp_dosen.kode, wp_tpa.kode) as bagian_kode'),
                    DB::raw('COALESCE(wp_dosen.position_name, wp_tpa.position_name) as bagian_nama'),
                    DB::raw('COALESCE(wp_dosen.type_work_position, wp_tpa.type_work_position) as bagian_tipe'),
                ])
                ->leftJoin('riwayat_nips as rn', function ($join) {
                    $join->on('users.id', '=', 'rn.users_id')
                        ->whereNull('rn.tmt_selesai');
                })
                ->leftJoin('dosens', 'users.id', '=', 'dosens.users_id')
                ->leftJoin('work_positions as wp_dosen', 'dosens.prodi_id', '=', 'wp_dosen.id')
                ->leftJoin('tpas', 'users.id', '=', 'tpas.users_id')
                ->leftJoin('work_positions as wp_tpa', 'tpas.bagian_id', '=', 'wp_tpa.id')
                ->orderBy('users.created_at', 'desc');

            if ($target === 'Active') {
                $query->where('users.is_active', 1);
            } elseif ($target === 'Nonactive') {
                $query->where('users.is_active', 0);
            }

            return $query->paginate(50);
        });

        $send = [$target];
        return view('kelola_data.pegawai.list', compact('send', 'users'));
    }

    public function new()
    {
        $options = Cache::rememberForever('pegawai_input_options', function () {
            return [
                'jenjang_pendidikan' => refJenjangPendidikan::all(),
                'status_pegawai'     => RefStatusPegawai::all(),
                'jenjang_jfa'        => RefPangkatGolongan::all(),
            ];
        });

        $jenjang_pendidikan_options = $options['jenjang_pendidikan'];
        $status_pegawai_options     = $options['status_pegawai'];
        $jenjang_jfa_options        = $options['jenjang_jfa'];

        $send = null;
        return view('kelola_data.pegawai.input', compact('send', 'jenjang_pendidikan_options', 'status_pegawai_options', 'jenjang_jfa_options'));
    }

    public function create(Request $request)
    {
        $response = $this->apiCreateCompleteAccount($request);

        if ($response->getStatusCode() === 200) {
            $responseData = $response->getData(true);
            $user = $responseData['data_return'];

            $this->clearPegawaiCache();
            return redirect(route('manage.pegawai.view.personal-info', ['idUser' => $user['id']]))
                ->with('success', 'Data pegawai berhasil disimpan!');
        } else {
            $responseData = $response->getData(true);
            $errorMessage = $responseData['error'] ?? 'Terjadi kesalahan sistem';

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal: ' . $errorMessage);
        }
    }

    protected function getPegawaiRules(Request $request, $id = null)
    {
        // dd($request->all());
        $namaLengkapInput = $request->input('nama_lengkap', []);
        $usernameInput = $request->input('username', []);
        $isBatch = is_array($namaLengkapInput);
        $suffix = $isBatch ? '.*' : '';

        $rules = [
            "nama_lengkap$suffix"       => ['required', 'string', 'max:100'],
            "nik$suffix"                => ['required', 'string', 'max:20'],
            "username$suffix"           => [
                'required',
                'alpha_dash',
                'string',
                $isBatch ? 'distinct' : '',
                $isBatch ? \Illuminate\Validation\Rule::unique('users', 'username') : \Illuminate\Validation\Rule::unique('users', 'username')->ignore($id)
            ],
            "telepon$suffix"            => ['required', 'string'],
            "email_pribadi$suffix"      => ['required', 'email:filter'],
            "email_institusi$suffix"    => ['required', 'email:filter'],
            "jenis_kelamin$suffix"      => ['required', 'in:Perempuan,Laki-laki'],
            "tgl_lahir$suffix"          => ['required', 'date'],
            "tipe_pegawai$suffix"       => ['required', 'in:Dosen,TPA'],
            "status_kepegawaian$suffix" => ['required', 'string'],
            "jabatan$suffix"            => ['required', 'string'],
            // "tipe_pegawai$suffix"        => ['required', Rule::in(['Dosen', 'TPA'])],
            "tmt_mulai$suffix"       => ['nullable', 'date', 'after:tgl_lahir'],
            "nip$suffix"                  => ['nullable', 'string', 'max:30'],
        ];

        $messages = [
            "required" => "Kolom :attribute wajib diisi.",
            "email"    => "Alamat email pada :attribute tidak valid.",
            "in"       => "Pilihan pada :attribute tidak tersedia.",
            "max"      => "Input pada :attribute terlalu panjang.",
            "date"     => "Format tanggal pada :attribute tidak valid.",
        ];

        $attributes = [];

        if ($isBatch) {
            foreach ($namaLengkapInput as $index => $value) {
                $valUsername = $usernameInput[$index] ?? '';

                $attributes["nama_lengkap.$index"]       = "Nama Lengkap";
                $attributes["nik.$index"]                = "NIK";
                $attributes["username.$index"]           = "Username";
                $attributes["telepon.$index"]            = "Nomor Telepon";
                $attributes["email_pribadi.$index"]      = "Email Pribadi";
                $attributes["email_institusi.$index"]    = "Email Institusi";
                $attributes["jenis_kelamin.$index"]      = "Jenis Kelamin";
                $attributes["tgl_lahir.$index"]          = "Tanggal Lahir";
                $attributes["tipe_pegawai.$index"]       = "Tipe Pegawai";
                $attributes["status_kepegawaian.$index"] = "Status Kepegawaian";
                $attributes["jabatan.$index"]            = "Jabatan";
                $attributes["tmt_mulai.$index"] = "Tertaut Mulai Tanggal";
                $attributes["nip.$index"]            = "Nomor Induk Pegawai";

                $messages["username.$index.unique"]   = "Username '$valUsername' sudah terdaftar, silakan gunakan yang lain.";
                $messages["username.$index.distinct"] = "Username '$valUsername' duplikat dengan baris lain.";
            }
        } else {
            $valUsername = $request->input('username');
            $messages["username.unique"] = "Username '$valUsername' sudah terdaftar, silakan gunakan yang lain.";

            $attributes = [
                "nama_lengkap" => "Nama Lengkap",
                "username"     => "Username",
                "nik"          => "NIK",
            ];
        }

        return [$rules, $messages, $attributes];
    }

    public function apiCreateCompleteAccount(Request $request)
    {

        // DD($request, $request['nip']);
        try {
            [$rules, $messages, $attributes] = $this->getPegawaiRules($request);

            // Debug 1: Apakah Rules-nya aman?
            // dd($rules); 

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);


            DB::beginTransaction();

            // 1. Tambahkan status_pegawai_id untuk RiwayatNip
            $validated = $validator->validated();
            // dd($validated['tmt_mulai']);
            $validated['status_pegawai_id'] = $validated['status_kepegawaian'];


            // 2. Buat Akun User
            $account = $this->create_account(new Request($validated));
            $validated['users_id'] = $account->id;
            // 3. Simpan Riwayat NIP
            $riwayatNip = RiwayatNip::create([
                'users_id' => $account->id,
                'nip' => $validated['nip'],
                'tmt_mulai' => $validated['tmt_mulai'],
                'status_pegawai_id' => $validated['status_kepegawaian']
            ]);

            // 4. Simpan Emergency Contacts (jika ada)
            $emergencyContacs = [];
            if ($request->has('emergency_contacts')) {
                foreach ($request->input('emergency_contacts') as $save) {
                    // dd($save);
                    $save['users_id'] = $account->id;
                    try {
                        $emergencyContacs[] = Emergency_contact::create($save);
                    } catch (\Exception $e) {
                        // Tangani error di sini
                        // dd('gagal ec', $save);
                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal membuat Ec',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }
            }

            // 5. Simpan Data Spesifik (Dosen/TPA)
            $tipe_pegawai = null;
            if ($validated['tipe_pegawai'] == 'Dosen') {
                $tipe_pegawai = Dosen::create($validated);
            } else {
                $tipe_pegawai = Tpa::create($validated);
            }

            DB::commit();
            $this->clearPegawaiCache();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Membuat User',
                'data_return' => [$account, $riwayatNip, $emergencyContacs, $tipe_pegawai],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat User',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function changePassword($idUser)
    {
        $user = (new ProfileController)->based_user_data($idUser);
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
        $user->password = bcrypt($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    public function setNonactive(Request $request, $idUser)
    {
        $user = User::find($idUser);
        $user->is_active = false;
        $user->save();

        $this->clearPegawaiCache();
        return redirect()->back()->with('success', 'Akun pegawai berhasil dinonaktifkan!');
    }

    public function setActive(Request $request, $idUser)
    {
        $user = User::find($idUser);
        $user->is_active = true;
        $user->save();

        $this->clearPegawaiCache();
        return redirect()->back()->with('success', 'Akun pegawai berhasil diaktifkan!');
    }

    public function dashboard()
    {
        $stats = Cache::remember('pegawai_stats', 3600, function () {
            return [
                'total' => User::count(),
                'dosen' => User::where('tipe_pegawai', 'Dosen')->count(),
                'tpa' => User::where('tipe_pegawai', 'TPA')->count(),
                'active' => User::where('is_active', 1)->count(),
                'male' => User::where('jenis_kelamin', 'Laki-laki')->count(),
                'female' => User::where('jenis_kelamin', 'Perempuan')->count(),
            ];
        });

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
                'max:10280',
                'mimes:xlsx,xls,csv,json',
            ],
        ], [
            'file.required' => 'Pilih file terlebih dahulu.',
            'file.file'     => 'Upload harus berupa file.',
            'file.max'      => 'Ukuran file melebihi 10 MB.',
            'file.mimes'    => 'Format file tidak diizinkan. Gunakan: xlsx, xls, csv, atau json.',
        ]);

        $file = $req->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        $data = array_values(array_filter(
            $sheet->toArray(null, true, true, true),
            fn($row) => (bool) array_filter($row)
        ));

        array_shift($data); // Hapus header
        $rows = $this->convertAllRow($data);

        session(['temp_rows' => $rows]);
        session(['old_data_import' => null]);

        return redirect()->route('manage.pegawai.import.validate-data')->with('message', 'Alert');
    }

    public function importValidateData()
    {
        $data = session('temp_rows');
        session(['temp_rows' => null]);
        $refStatusKepegawaian = RefStatusPegawai::orderBy('status_pegawai', 'asc')
            ->pluck('status_pegawai', 'status_pegawai');

        $refFormasi = formation::orderBy('nama_formasi', 'asc')
            ->pluck('nama_formasi', 'nama_formasi');

        return view('kelola_data.pegawai.import.preview-data', [
            'data' => $data,
            'refStatusKepegawaian' => $refStatusKepegawaian,
            'refFormasi' => $refFormasi
        ]);
    }

    public function convertAllRow($data)
    {
        $out = [];
        // dd($data);
        foreach ($data as $index => $row) {
            $out[] = $this->convertRow($row);



            // dd($out[$index]);
        }


        return $out;
    }

    // public function isEmergencyContactFill($data) {}

    public function convertRow($data)
    {
        $out = [];
        $ref = $this->colToField();
        $cekEmergency = 1;
        $cekIsi = false;
        $countCekEc = 5;
        foreach ($ref as $col => $field) {
            $out[$field] = $data[$col] ?? null;
            // dd($out[$field], $data[$col],$ref,$field);
            if (str_contains($field, "ec" . $cekEmergency)) {
                // dd('masuk',$out[$field]);
                if ($out[$field] != null) {
                    $cekIsi = true;
                }
                $countCekEc--;
                if ($countCekEc == 0) {
                    // dd($cekEmergency);
                    $out['ec' . $cekEmergency] = $cekIsi;
                    $cekEmergency++;
                    $countCekEc = 5;
                    $cekIsi = false;
                }
            }
        }
        return $out;
    }

    public function colToField()
    {
        return [
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
            'P'  => 'jabatan',
            'Q'  => 'ec1_status_hubungan',
            'R'  => 'ec1_nama_lengkap',
            'S'  => 'ec1_telepon',
            'T'  => 'ec1_email',
            'U'  => 'ec1_alamat',
            'V'  => 'ec2_status_hubungan',
            'W'  => 'ec2_nama_lengkap',
            'X'  => 'ec2_telepon',
            'Y'  => 'ec2_email',
            'Z'  => 'ec2_alamat',
            'AA' => 'ec3_status_hubungan',
            'AB' => 'ec3_nama_lengkap',
            'AC' => 'ec3_telepon',
            'AD' => 'ec3_email',
            'AE' => 'ec3_alamat',
            'AF' => 'ec4_status_hubungan',
            'AG' => 'ec4_nama_lengkap',
            'AH' => 'ec4_telepon',
            'AI' => 'ec4_email',
            'AJ' => 'ec4_alamat'
        ];
    }

    public function importSaveData(Request $request)
    {
        // dd($request);
        $sv = $request->all();
        // dd(session('temp_rows')==$request,session('temp_rows'),$request,$request['DataChanges']);
        // $backData = null;
        session(['old_data_import' => $request->all()]);

        try {
            // Normalisasi Tanggal sebelum validasi
            $tglLahir = $request->input('tgl_lahir', []);
            foreach ($tglLahir as $i => $tgl) {
                $tglLahir[$i] = $this->normalizeDate(trim($tgl));
            }

            $tmt = $request->input('tmt_mulai', []);
            foreach ($tmt as $i => $tgl) {
                $tmt[$i] = $this->normalizeDate(trim($tgl));
            }

            $request->merge(['tgl_lahir' => $tglLahir, 'tmt_mulai' => $tmt]);
            // dd($request->all());
            // dd($request,$sv);

            // 1. Ambil rules secara dinamis (otomatis mendeteksi tunggal atau batch)
            [$rules, $messages, $attributes] = $this->getPegawaiRules($request);

            // Masukkan ketiga variabel tersebut ke Validator
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            // session(['old_data_import' => old()]);
            // dd(old());
            // dd('aman');
            // dd($validator->validated());
            
            // dd($validator);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $allData = $request->all();
            $rowCount = count($allData['nama_lengkap']);

            DB::beginTransaction();
            $cekTrue = false;
            // dd($allData);
            for ($idx = 0; $idx < $rowCount; $idx++) {
                $userNew = [];
                // Map data per baris
                foreach ($allData as $key => $values) {
                    if (is_array($values) && isset($values[$idx])) {
                        if (preg_match('/^(ec[1-4])_(.+)$/', $key, $m)) {
                            $userNew[$m[1]][$m[2]] = $values[$idx];
                        } else {
                            $userNew[$key] = $values[$idx];
                        }
                    }
                }

                // Konversi Nama Jabatan ke ID
                if ($userNew['jabatan'] != null) {
                    $formasi = formation::where('nama_formasi', $userNew['jabatan'])->first();
                    $userNew['jabatan_id'] = $formasi ? $formasi->id : null;
                    if ($userNew['jabatan_id'] == null) {
                        throw new \Exception('jabatan: ' . $userNew['jabatan'] . ', tidak terdaftar disistem kami, silahkan cek juga jabatan yang lain, pastikan sesuai dengan yang ada di dropdown.');
                    }
                }
                // if($userNew['jabatan_id']==null){
                //     dd($userNew);
                // }

                // Konversi Nama Status ke ID
                $status = RefStatusPegawai::where('status_pegawai', $userNew['status_kepegawaian'])->first();
                // dd($userNew['status_kepegawaian']);
                $temp_save = $userNew['status_kepegawaian'];
                $userNew['status_kepegawaian'] = $status ? $status->id : null;
                if ($userNew['status_kepegawaian'] == null) {
                    throw new \Exception("Status Kepegawaian:" . $temp_save . ", tidak terdaftar disistem kami, silahkan cek juga Status Kepegawaian yang lain, pastikan sesuai dengan yang ada di dropdown.");
                }

                // Siapkan EC array untuk apiCreateCompleteAccount
                $ecs = [];
                foreach (['ec1', 'ec2', 'ec3', 'ec4'] as $ecKey) {
                    if (!empty($userNew[$ecKey]['nama_lengkap'])) {
                        $ecs[] = $userNew[$ecKey];
                    }
                }
                $userNew['emergency_contacts'] = $ecs;

                // Panggil fungsi create
                $req = new Request($userNew);
                // dd('masuk2');
                $Akun = $this->apiCreateCompleteAccount($req);
                // dd(($Akun->getData(true))['data_return'] ?? ($Akun->getData(true))['error']);
                dd($Akun->getStatusCode());
                if ($Akun->getStatusCode() != 200) {
                    // dd($Akun);
                    throw new \Exception(($Akun->getData(true))['error']);
                }
            }
            // if ($cekTrue == true) {
            DB::commit();
            $this->clearPegawaiCache();
            return redirect(route('manage.pegawai.list', ['destination' => 'Active']))->with('success', 'Import data berhasil!');
            // }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd(old(),session('old_data_import'));
            // session(['old_data_import' => old()]);
            // dd($e);
            $friendlyMessage = ErrorParser::parse($e);
            return redirect()->back()->with('error', $friendlyMessage);
        }
    }

    public function normalizeDate($value)
    {
        if (empty($value)) return null;
        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) return $value;
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function create_account(Request $request)
    {
        $data = $request->all();
        // Password default bcrypt
        $rawPass = strtolower(str_replace(' ', '', ($data['telepon'] ?? '12345') . '&' . $data['nama_lengkap']));
        $data['password'] = bcrypt($rawPass);
        $data['tgl_bergabung'] = $data['tmt_mulai'] ?? now();
        $data['is_active'] = true;

        return User::create($data);
    }
}
