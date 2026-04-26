<?php

namespace App\Http\Controllers;

use App\Models\RefStatusPegawai;
use App\Models\RiwayatNip;
use App\Models\SK;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class RiwayatNipController extends Controller
{
    public function index()
    {
        $nips = RiwayatNip::with(['statusPegawai', 'sk_or_amandemen'])->get();
        return view('kelola_data.riwayat-nip.list', compact('nips'));
    }

    public function new()
    {
        $users = User::all()->sortBy('nama_lengkap');
        $sk_ypts = SK::Sk_Ypt();
        // dd($sk_ypts);
        $status_pegawai = RefStatusPegawai::all()->sortBy('status_pegawai');
        // dd($status_pegawai);
        $route = view('kelola_data.riwayat-nip.input', compact('users', 'sk_ypts', 'status_pegawai'));
            return $this->CekReview($route, '1G3', 'MELIHAT DATA NIP');

    }

    public function create_data(Request $request)
    {
        $validated = $this->validation($request);
        // dd('masuk');
        try {
            $response = $this->create($request);
            $responseData = $response->getData(true);

            $route = null;

            if ($response->getStatusCode() === 200) {
                DB::commit();

                $user = $responseData['data'];

                $route = redirect(route('manage.riwayat-nip.list'))
                    ->with('success', 'Data pegawai berhasil disimpan!');
            } else {
                // Ini menangkap error logic dari API (misal: NIK sudah terdaftar di DB)
                DB::rollBack();
                $errorMessage = $responseData['error'] ?? 'Terjadi kesalahan pada sistem simpan.';

                $route = redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => $errorMessage]);
            }

            return $this->CekReview($route, '1G1', 'MENAMBAH DATA NIP');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memproses data: ' . $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {
        $validated = $this->validation($request);
        if ($validated['no_sk'] != null) {
            $validated['sk_ypt_or_amandemen'] = null;
        }
        try {
            DB::beginTransaction();
            if ($validated['sk_ypt_or_amandemen'] == null) {
                // dd('masuk');

                try {

                    $validated['tipe_sk'] = 'Pengakuan YPT';
                    $validated['keperluan'] = 'NIP';
                    $validated['file_sk'] = $request->file('file_sk');
                    $validated['keterangan'] = 'Penambahan NIP Pegawai';
                    // dd($validated);

                    $response = (new SKController())->new(new Request($validated), 'Ypt', false);
                    $sk = $response->getData()->data;
                    $validated['sk_ypt_or_amandemen'] = $sk->id;

                    // dd($validated);
                } catch (\Exception $e) {
                    // DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat SK YPT',
                        'error' => $e->getMessage()
                    ], 500);
                }
                // $validated['users_id'] = $request->users_id;

            }
            // $level = Formation::create($validated);
            $save = RiwayatNip::create($validated);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Membuat data NIP',
                'data' => $save
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Formasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_data($id_nip)
    {
        $nip = RiwayatNip::where('id', $id_nip)->first();
        if (!$nip) {
            return redirect()->back()->with('error_alert', 'Nip Tidak Ditemukan!');
        }
        // dd($nip);

        $users = User::all()->sortBy('nama_lengkap');
        $sk_ypts = SK::Sk_Ypt();
        // dd($sk_ypts);
        $status_pegawai = RefStatusPegawai::all()->sortBy('status_pegawai');
        // dd($status_pegawai);
        return view('kelola_data.riwayat-nip.update', compact('users', 'sk_ypts', 'status_pegawai', 'nip'));
    }

    public function update(Request $request, $id_nip)
    {
        $validated = $this->validation($request);
        // dd('masuk');
        try {
            $nip = null;
            try {
                $nip = RiwayatNip::findorFail($id_nip);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Nomor Induk Kepegawaian ini tidak terdaftar!.');
            }
            $nip->update($validated);
            DB::commit();
            // $save = RiwayatNip::update($validated);
            // $nip = RiwayatNip::where('id', $id_nip)->update($validated);
            // $response = RiwayatNip::update($request);
            // $responseData = $response->getData(true);


            // $user = $responseData['data'];

            $route = redirect(route('manage.riwayat-nip.list'))
                ->with('success', 'Data pegawai berhasil disimpan!');

            return $this->CekReview($route, '1G2', 'MENGUBAH DATA NIP');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memproses data: ' . $e->getMessage()]);
        }
    }

    public function validation(Request $request)
    {
        return $validated = $request->validate([
            'users_id'          => ['required'],
            'status_pegawai_id' => ['required'],
            'nip'               => ['required'],
            'tmt_mulai'  => ['required', 'date'],
            'tmt_selesai'  => ['nullable', 'date'],
            'sk_ypt_or_amandemen'  => ['nullable', 'required_without_all:file_sk,no_sk'],
            'file_sk'    => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'required_without:sk_ypt_or_amandemen'],
            'no_sk'      => ['nullable', 'string', 'max:50', 'required_without:sk_ypt_or_amandemen'],
        ], [
            'required' => ':attribute wajib diisi.',
            'date'     => ':attribute harus berupa tanggal yang valid.',
            'required_without'      => ':attribute wajib diisi jika :values tidak ada.',
            'required_without_all'  => ':attribute wajib diisi jika :values tidak ada semuanya.',
        ], [
            // optional: ganti nama attribute biar rapi
            'sk_ypt_or_amandemen' => 'SK YPT atau Amandemen',
            'file_sk'   => 'file SK',
            'no_sk'     => 'nomor SK',
            'status_pegawai_id' => 'Status Pegawai',
            'nip' => 'Nomor Induk Pegawai (NIP)',
            'tmt_mulai' => 'Terhitung Mulai Tanggal',
            'tmt_selesai' => 'Selesai Pada Tanggal'
        ]);
    }

    public function history_nip($id_pegawai)
    {
        if ($this->onlyOwnerAndAdmin($id_pegawai)==true) {

            $user = (new ProfileController)->based_user_data($id_pegawai);
            $nips = RiwayatNip::with('statusPegawai')->where('users_id', $id_pegawai)->get();
            // dd($nips);
            $route = view('kelola_data.pegawai.view.history.nip', compact('nips', 'user'));
            return $this->CekReview($route, '1G4', 'MELIHAT HISTORY NIP');
        }
        return redirect(route('profile.personal-info', ['idUser' => session('account')['id']]))->with('error_alert', 'Anda hanya boleh mengelola data anda sendiri!.');;

    }
}
