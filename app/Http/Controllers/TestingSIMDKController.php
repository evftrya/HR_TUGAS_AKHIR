<?php

namespace App\Http\Controllers;

use App\Models\TestingSIMDK;
use Illuminate\Http\Request;

class TestingSIMDKController extends Controller
{
    public function submit_review(Request $request, $kode, $nama_fitur = null)
    {
        try {
            $userId = session('account')['id'];

            // ambil atau buat data user
            $model = TestingSIMDK::firstOrCreate(
                ['users_id' => $userId]
            );

            // ambil data lama
            $data = $model->test_statuses ?? [];
            // dd($data);
            // ambil data berdasarkan kode
            $current = $data[$kode] ?? [];
            // dd($current);
            $this->MakeLog('User Mereview fitur kode ' . $kode);

            // cek apakah sudah done
            if (($current['name'] ?? null) === $nama_fitur && ($current['status'] ?? null) === 'done') {
                $this->MakeLog('User Tidak Jadi Mereview karena sudah pernah review ' . $kode, ['ini tablenya' => $current]);
                return response()->json([
                    'success' => true,
                    'data' => 'sudah mengisi review'
                ], 200);
            };

            // update / tambah data
            $data[$kode] = [
                'name' => $nama_fitur,
                'status' => 'done',
                'updated_at' => now()->toDateTimeString()
            ];

            // simpan
            $model->update([
                'test_statuses' => $data
            ]);

            $this->MakeLog('User Berhasil Mereview terkait ' . $kode, ['ini tablenya' => $model]);


            return response()->json([
                'success' => true,
                'data' => $model
            ], 200);
        } catch (\Exception $e) {
            $this->MakeLog('User Tidak Jadi Mereview terjadi masalah terkait kode ' . $kode, ['ini alasannya' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cek_review($kode)
    {
        $cek_exist = TestingSIMDK::where('users_id', session('account')['id'])->first();

        // kalau belum ada data sama sekali → perlu review

        $statuses = $cek_exist->test_statuses ?? [];
        // dd($statuses, $kode);

        // kalau kode belum ada di JSON → perlu review
        if ($cek_exist && array_key_exists($kode, $statuses)) {
            $this->MakeLog('User Tidak Perlu Perlu Mereview terkait ' . $kode, $statuses);
            // dd('masuk 1');
            return true;
        }

        // dd('masuk 2');
        $this->MakeLog('User Perlu Mereview terkait ' . $kode, $statuses);
        return false;
    }

    public function switchRole($role_name)
    {
        $user = null;
        switch ($role_name) {
            case 'pegawai':
                $user = \App\Models\User::where('is_admin', false)->first();
                break;
            case 'atasan':
                $user = \App\Models\User::where('role', 'atasan')->first();
                if (!$user) {
                    $user = \App\Models\User::where('is_admin', false)->inRandomOrder()->first();
                }
                break;
            case 'pimpinan':
                $user = \App\Models\User::where('role', 'pimpinan')->first();
                if (!$user) {
                    $user = \App\Models\User::where('is_admin', false)->inRandomOrder()->first();
                }
                break;
        }

        if ($user) {
            session(['original_admin_id' => auth()->id()]);
            session(['impersonate_role' => $role_name]);
            \Illuminate\Support\Facades\Auth::loginUsingId($user->id);
            return redirect('/kinerja_pegawai')->with('success', "Berhasil menyamar sebagai Mode " . ucfirst($role_name));
        }

        return redirect()->back()->with('error', 'User representatif untuk role tersebut tidak ditemukan.');
    }

    public function leaveImpersonate()
    {
        if (session()->has('original_admin_id')) {
            $originalId = session('original_admin_id');
            \Illuminate\Support\Facades\Auth::loginUsingId($originalId);
            session()->forget('original_admin_id');
            session()->forget('impersonate_role');
            return redirect('/kinerja_pegawai')->with('success', 'Berhasil kembali ke Mode Admin SDM');
        }

        return redirect('/kinerja_pegawai');
    }
}
