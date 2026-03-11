<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorParser;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Emergency_contact;
use App\Models\formation;
use App\Models\RefStatusPegawai;
use App\Models\RiwayatNip;
use App\Models\Tpa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PegawaiController extends Controller
{

    public function index($destination)
    {
        $target = ucfirst(strtolower($destination));
        $validTargets = ['Active', 'Nonactive', 'Semua'];

        if (!in_array($target, $validTargets)) {
            return redirect('/manage/pegawai/list/Semua');
        }

        if ($destination !== $target) {
            return redirect('/manage/pegawai/list/' . $target);
        }

        $query = User::query()
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

        $users = $query->paginate(50);

        $send = [$target];
        return view('kelola_data.pegawai.list', compact('send', 'users'));
    }


    public function new()
    {
        $jenjang_pendidikan_options = \App\Models\refJenjangPendidikan::all();
        $status_pegawai_options = RefStatusPegawai::all();
        $jenjang_jfa_options = \App\Models\RefPangkatGolongan::all();

        $send = null;

        return view(
            'kelola_data.pegawai.input',
            compact(
                'send',
                'jenjang_pendidikan_options',
                'status_pegawai_options',
                'jenjang_jfa_options'
            )
        );
    }


    public function create(Request $request)
    {
        [$rules, $messages, $attributes] = $this->getPegawaiRules($request);

        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages,
            $attributes
        );

        $validator->validated();

        $response = DB::transaction(function () use ($request) {
            return $this->apiCreateCompleteAccount($request);
        });

        if ($response->getStatusCode() === 200) {

            $responseData = $response->getData(true);
            $user = $responseData['data_return'];

            return redirect(
                route('manage.pegawai.view.personal-info', [
                    'idUser' => $user['id']
                ])
            )->with('success', 'Data pegawai berhasil disimpan!');
        }

        $responseData = $response->getData(true);
        $errorMessage = $responseData['error'] ?? 'Terjadi kesalahan sistem';

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal: ' . $errorMessage);
    }


    protected function getPegawaiRules(Request $request, $id = null)
    {
        $namaLengkapInput = $request->input('nama_lengkap');
        $isBatch = is_array($namaLengkapInput);
        $suffix = $isBatch ? '.*' : '';

        $rules = [

            "nama_lengkap$suffix" => ['required', 'string', 'max:100'],
            "nik$suffix" => ['required', 'string', 'max:20'],

            "username$suffix" => [
                'required',
                'alpha_dash',
                'string',
                $isBatch ? 'distinct' : '',
                $isBatch
                    ? \Illuminate\Validation\Rule::unique('users', 'username')
                    : \Illuminate\Validation\Rule::unique('users', 'username')->ignore($id)
            ],

            "telepon$suffix" => ['required', 'string'],

            "email_pribadi$suffix" => ['required', 'email:filter'],
            "email_institusi$suffix" => ['required', 'email:filter'],

            "jenis_kelamin$suffix" => ['required', 'in:Perempuan,Laki-laki'],

            "tgl_lahir$suffix" => ['required', 'date'],

            "tipe_pegawai$suffix" => ['required', 'in:Dosen,TPA'],

            "status_kepegawaian$suffix" => ['required', 'string'],

            "jabatan$suffix" => ['nullable', 'string'],

            "tmt_mulai$suffix" => [
                'nullable',
                'date',
                'after:tgl_lahir' . ($isBatch ? $suffix : '')
            ],

            "nip$suffix" => ['nullable', 'string', 'max:30'],
        ];

        $messages = [

            "required" => "Kolom :attribute wajib diisi.",
            "email" => "Alamat email pada :attribute tidak valid.",
            "in" => "Pilihan pada :attribute tidak tersedia.",
            "max" => "Input pada :attribute terlalu panjang.",
            "date" => "Format tanggal pada :attribute tidak valid.",
            "after" => "Tanggal :attribute harus setelah Tanggal Lahir.",
        ];

        $attributes = [

            "nama_lengkap" => "Nama Lengkap",
            "username" => "Username",
            "nik" => "NIK",
        ];

        return [$rules, $messages, $attributes];
    }


    public function apiCreateCompleteAccount(Request $request)
    {
        try {

            [$rules, $messages, $attributes] = $this->getPegawaiRules($request);

            $validator = Validator::make(
                $request->all(),
                $rules,
                $messages,
                $attributes
            );

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'error' => $validator->errors()->first()
                ], 422);
            }

            $validated = $validator->validated();

            $validated['status_pegawai_id'] =
                $request->status_kepegawaian_id
                ?? $validated['status_kepegawaian'];


            $account = $this->create_account(new Request($validated));

            RiwayatNip::create([
                'users_id' => $account->id,
                'nip' => $validated['nip'],
                'tmt_mulai' => $validated['tmt_mulai'],
                'status_pegawai_id' => $validated['status_pegawai_id']
            ]);


            if ($request->has('emergency_contacts')) {

                foreach ($request->input('emergency_contacts') as $ecData) {

                    $ecData['users_id'] = $account->id;

                    Emergency_contact::create($ecData);
                }
            }


            $validated['users_id'] = $account->id;

            if ($validated['tipe_pegawai'] == 'Dosen') {

                Dosen::create($validated);
            } else {

                Tpa::create($validated);
            }


            return response()->json([
                'success' => true,
                'data_return' => $account
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function changePassword($idUser)
    {
        $user = (new ProfileController)->based_user_data($idUser);

        return view(
            'kelola_data.pegawai.change-password',
            compact('user')
        );
    }


    public function updatePassword(Request $request, $idUser)
    {
        $validated = $request->validate([

            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]

        ]);

        $user = User::find($idUser);

        $user->password = bcrypt($validated['password']);

        $user->save();

        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui!');
    }


    public function setNonactive($idUser)
    {
        $user = User::find($idUser);

        $user->is_active = false;

        $user->save();

        return redirect()->back()
            ->with('success', 'Akun pegawai berhasil dinonaktifkan!');
    }


    public function setActive($idUser)
    {
        $user = User::find($idUser);

        $user->is_active = true;

        $user->save();

        return redirect()->back()
            ->with('success', 'Akun pegawai berhasil diaktifkan!');
    }


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

        $recentEmployees = User::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view(
            'kelola_data.pegawai.dashboard',
            compact('stats', 'recentEmployees')
        );
    }


    public function normalizeDate($value)
    {
        if (empty($value)) return null;

        try {

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                return $value;
            }

            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) {

                return Carbon::createFromFormat('d/m/Y', $value)
                    ->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {

            return null;
        }
    }


    public function create_account(Request $request)
    {
        $data = $request->all();

        $rawPass = strtolower(
            str_replace(
                ' ',
                '',
                ($data['telepon'] ?? '12345')
                . '&'
                . $data['nama_lengkap']
            )
        );

        $data['password'] = bcrypt($rawPass);

        $data['tgl_bergabung'] =
            $data['tmt_mulai']
            ?? now();

        $data['is_active'] = true;

        return User::create($data);
    }
}