<?php

namespace App\Http\Controllers;

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
     * Dipanggil setiap kali ada perubahan data (Create, Update, Status Change).
     */
    private function clearPegawaiCache()
    {
        Cache::forget('pegawai_list_active');
        Cache::forget('pegawai_list_nonactive');
        Cache::forget('pegawai_list_semua');
        Cache::forget('pegawai_stats');
    }

    /**
     * Display a listing of the resource.
     * Menggunakan Cache::remember untuk menghindari query berat berulang.
     */
    public function index($destination)
    {
        $text = ucwords(strtolower($destination));

        if (!in_array($text, ['Active', 'Nonactive', 'Semua'])) {
            return redirect('/manage/pegawai/list/Semua');
        }

        // Menggunakan query() untuk Symfony 7.4 compatibility agar log bersih
        $page = request()->query('page', 1);
        $cacheKey = 'pegawai_list_' . strtolower($destination) . '_p' . $page;

        $users = Cache::remember($cacheKey, 3600, function () use ($destination) {
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
                ->leftJoin('work_positions as wp_tpa', 'tpas.bagian_id', '=', 'wp_tpa.id');

            if ($destination === 'Active') {
                $query->where('users.is_active', 1);
            } elseif ($destination === 'Nonactive') {
                $query->where('users.is_active', 0);
            }

            // SET KE 10 DATA PER HALAMAN
            return $query->paginate(50);
        });

        $send = [$text];
        return view('kelola_data.pegawai.list', compact('send', 'users'));
    }

    public function new()
    {
        /**
         * Menggabungkan data referensi dalam satu key cache 'pegawai_input_options'.
         * Ini mengurangi 3 query database cache menjadi hanya 1 query.
         */
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
        $user = $response->getData(true)['data_return'];

        if ($response->getStatusCode() === 200) {
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

    public function apiCreateCompleteAccount(Request $request)
    {
        $tipe = strtolower((string) $request->input('tipe_pegawai'));
        $validated = $request->validate([
            'nik'               => ['nullable', 'string', 'max:20'],
            'nama_lengkap'      => ['required', 'string', 'max:100'],
            'username'          => ['required', 'alpha_dash', 'min:3', 'max:20'],
            'telepon'           => ['nullable', 'regex:/^0\d{9,12}$/'],
            'alamat'            => ['nullable', 'string', 'max:300'],
            'email_pribadi'     => ['nullable', 'email:filter', 'max:150'],
            'email_institusi'   => ['nullable', 'email:filter', 'max:150'],
            'jenis_kelamin'     => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'tempat_lahir'      => ['nullable', 'string', 'max:100'],
            'tgl_lahir'         => ['nullable', 'date', 'before:today'],
            'tipe_pegawai'      => ['required', Rule::in(['Dosen', 'TPA'])],
            'tmt_mulai'         => ['nullable', 'date', 'after:tgl_lahir'],
            'status_kepegawaian' => 'required',
            'nip'               => ['nullable', 'string', 'max:30'],
        ], [
            'required' => ':attribute wajib diisi.',
            'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'max' => ':attribute maksimal :max karakter.',
            'min' => ':attribute minimal :min karakter.',
            'email' => 'Format :attribute tidak se valid.',
            'in' => ':attribute tidak valid.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'before' => ':attribute harus sebelum hari ini.',
            'after' => ':attribute harus setelah :date.',
            'numeric' => ':attribute harus berupa angka.',
            'integer' => ':attribute harus berupa angka bulat.',
            'digits' => ':attribute harus terdiri dari :digits digit.',
            'between' => ':attribute harus antara :min dan :max.',
            'regex' => 'Format :attribute tidak se valid.',
            'file' => ':attribute harus berupa file.',
            'mimes' => ':attribute harus berformat: :values.',
            'max.file' => ':attribute maksimal :max kilobyte.',
            'telepon.regex' => 'Nomor telepon harus diawali 0 dan berjumlah 10–13 digit.',
            'emergency_contact_phone.regex' => 'Nomor telepon darurat harus diawali 0 dan berjumlah 10–13 digit.',
            'nomor_induk_pegawai.required' => 'Nomor Induk Pegawai/NUPTK wajib diisi untuk Dosen.',
        ]);

        try {
            DB::beginTransaction();

            $validated['status_pegawai_id'] = $validated['status_kepegawaian'];
            $validated['users_id'] = null;
            $req = new Request($validated);

            $account = $this->create_account($req);
            $validated['users_id'] = $account->id;

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
                if ($request->has('emergency_contacts')) {
                    foreach ($request['emergency_contacts'] as $save) {
                        $save['users_id'] = $validated['users_id'];
                        Emergency_contact::create($save);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat Emergency Contact',
                    'error' => $e->getMessage()
                ], 500);
            }

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

            DB::commit();
            $this->clearPegawaiCache();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Membuat User',
                'data_return' => $account
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
        $user->password = $validated['password'];
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
            'file.max'      => 'Ukuran file melebihi 25 MB.',
            'file.mimes'    => 'Format file tidak diizinkan. Gunakan: xlsx, xls, csv, atau json.',
        ]);

        $file = $req->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        $data = array_values(array_filter(
            $sheet->toArray(null, true, true, true),
            fn($row) => (bool) array_filter($row)
        ));

        array_shift($data);
        $rows = $this->convertAllRow($data);

        session(['temp_rows' => $rows]);
        return redirect()->route('manage.pegawai.import.validate-data');
    }

    public function importValidateData()
    {
        $data = session('temp_rows');
        $refStatusKepegawaian = RefStatusPegawai::orderBy('status_pegawai', 'asc')
            ->pluck('status_pegawai')
            ->combine(RefStatusPegawai::orderBy('status_pegawai', 'asc')->pluck('status_pegawai'));
        // $refStatusKepegawaian = RefStatusPegawai::orderBy('status_pegawai', 'asc')->pluck('status_pegawai');
        // $refFormasi = formation::orderBy('nama_formasi', 'asc')->pluck('nama_formasi');
        $refFormasi = formation::orderBy('nama_formasi', 'asc')
            ->pluck('nama_formasi')
            ->combine(formation::orderBy('nama_formasi', 'asc')->pluck('nama_formasi'));
        // dd($refStatusKepegawaian, $bagians);

        return view('kelola_data.pegawai.import.preview-data', ['data' => $data, 'refStatusKepegawaian' => $refStatusKepegawaian, 'refFormasi' => $refFormasi]);
    }

    public function convertAllRow($data)
    {
        $out = [];
        foreach ($data as $index => $row) {
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
            'Z' => 'ec2_alamat',
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
        $tglLahir = $request->input('tgl_lahir', []);
        foreach ($tglLahir as $i => $tgl) {
            $tglLahir[$i] = $this->normalizeDate(trim($tgl));
        }

        $tmt = $request->input('tmt_mulai', []);
        foreach ($tmt as $i => $tgl) {
            $tmt[$i] = $this->normalizeDate(trim($tgl));
        }

        $request->merge([
            'tgl_lahir' => $tglLahir,
            'tmt_mulai' => $tmt,
        ]);

        $rules = [
            'nama_lengkap'      => ['required', 'array'],
            'nama_lengkap.*'    => ['required', 'string'],
            'nik'               => ['required', 'array'],
            'nik.*'             => ['required', 'string'],
            'username'          => ['required', 'array'],
            'username.*'        => ['required', 'alpha_dash', 'string'],
            'telepon'           => ['required', 'array'],
            'telepon.*'         => ['required', 'string'],
            'email_pribadi'     => ['required', 'array'],
            'email_pribadi.*'   => ['required', 'email:filter', 'max:150'],
            'email_institusi'   => ['required', 'array'],
            'email_institusi.*' => ['required', 'email:filter', 'max:150'],
            'telepon_darurat'   => ['required', 'array'],
            'telepon_darurat.*' => ['required', 'string'],
            'jenis_kelamin'     => ['required', 'array'],
            'jenis_kelamin.*'   => ['required', 'in:Perempuan,Laki-laki'],
            'alamat'            => ['required', 'array'],
            'alamat.*'          => ['required', 'string'],
            'tempat_lahir'      => ['required', 'array'],
            'tempat_lahir.*'    => ['required', 'string'],
            'tgl_lahir'         => ['required', 'array'],
            'tgl_lahir.*'       => ['required', 'date'],
            'tipe_pegawai'      => ['required', 'array'],
            'tipe_pegawai.*'    => ['required', 'in:Dosen,TPA'],
            'status_kepegawaian' => ['required', 'array'],
            'status_kepegawaian.*' => ['required', 'string'],
            'nip'               => ['required', 'array'],
            'nip.*'             => ['required', 'string'],
            'jabatan'               => ['required', 'array'],
            'jabatan.*'             => ['required', 'string'],
            'tmt_mulai'         => ['nullable', 'array'],
            'tmt_mulai.*'       => ['nullable', 'date'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($v) use ($request) {
            $rows = count($request->input('nama_lengkap', []));
            for ($idx = 0; $idx < $rows; $idx++) {
                $hasAtLeastOneEC = false;
                foreach ([1, 2, 3, 4] as $i) {
                    $status = trim((string)($request->input("ec{$i}_status_hubungan.$idx") ?? ''));
                    $nama   = trim((string)($request->input("ec{$i}_nama_lengkap.$idx") ?? ''));
                    $telp   = trim((string)($request->input("ec{$i}_telepon.$idx") ?? ''));
                    $email  = trim((string)($request->input("ec{$i}_email.$idx") ?? ''));
                    $alamat = trim((string)($request->input("ec{$i}_alamat.$idx") ?? ''));

                    if ($status !== '') {
                        if ($nama === '') $v->errors()->add("ec{$i}_nama_lengkap.$idx", "Row " . ($idx + 1) . ": EC{$i} Nama Lengkap wajib diisi.");
                        if ($telp === '') $v->errors()->add("ec{$i}_telepon.$idx", "Row " . ($idx + 1) . ": EC{$i} Telepon wajib diisi.");
                        if ($email === '') $v->errors()->add("ec{$i}_email.$idx", "Row " . ($idx + 1) . ": EC{$i} Email wajib diisi.");
                        if ($alamat === '') $v->errors()->add("ec{$i}_alamat.$idx", "Row " . ($idx + 1) . ": EC{$i} Alamat wajib diisi.");
                    }

                    if ($status !== '' && $nama !== '' && $telp !== '' && $email !== '' && $alamat !== '') {
                        $hasAtLeastOneEC = true;
                    }
                }
                if (!$hasAtLeastOneEC) {
                    $v->errors()->add("ec1_status_hubungan.$idx", "Row " . ($idx + 1) . ": Minimal 1 Emergency Contact lengkap wajib diisi.");
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();
        $result = [];

        foreach ($validated as $field => $values) {
            foreach ($values as $i => $value) {
                if($field=='jabatan'){
                    $temp = formation::where('nama_formasi',$value)->first()->id;
                    // DD($field,$i,$values,$value,$temp);
                    $value = $temp;
                }

                if($field=='status_kepegawaian'){
                    $temp = RefStatusPegawai::where('status_pegawai',$value)->first()->id;
                    // DD($field,$i,$values,$value,$temp);
                    $value = $temp;
                }

                if (preg_match('/^(ec[1-4])_(.+)$/', $field, $m)) {
                    $result[$i][$m[1]][$m[2]] = $value;
                } else {
                    $result[$i][$field] = $value;
                }
            }
        }

        try {



            DB::beginTransaction();
            // dd($result);
            // Implementasi Loop untuk multi row jika diperlukan, di sini contoh baris pertama
            foreach($result as $userNew){
                $req = new Request($userNew);
                $users_new = $this->apiCreateCompleteAccount($req);
            }
            // dd($this->apiCreateCompleteAccount($req));
            DB::commit();

            // dd($users_new);
            $this->clearPegawaiCache();
            return redirect(route('manage.pegawai.list', ['destination' => 'Active']));
            // return redirect(route('manage.pegawai.view.personal-info', ['idUser' => $users_new['id']]))->with('success', 'Data pegawai berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
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
        $data['password'] = strtolower(str_replace(' ', '', ($data['telepon'] ?? '12345') . '&' . $data['nama_lengkap']));
        $data['tgl_bergabung'] = $data['tmt_mulai'] ?? null;

        $user = User::create($data);
        return $user;
    }
}
