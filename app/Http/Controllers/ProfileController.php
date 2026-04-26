<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Dosen;
use App\Models\RefStatusPegawai;
use App\Models\RiwayatNip;
use App\Models\Tpa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */


    public function destroy(Request $request): RedirectResponse
    {
        // 1. Validasi
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $userId = $user->id; // Simpan ID sebelum didelete untuk hapus cache

        // 2. HAPUS CACHE SPESIFIK USER (Jika kamu pakai caching)
        // Misalnya kamu menyimpan data user di cache dengan key 'user_data_1'
        Cache::forget('user_role_' . $userId);
        Cache::forget('user_permissions_' . $userId);

        // Jika ingin ekstrim hapus semua cache aplikasi (Hati-hati: ini menghapus cache user lain juga)
        // Cache::flush();

        // 3. Proses Delete & Logout
        Auth::logout();
        $user->delete();

        // 4. BERSIHKAN SESSION TOTAL
        $request->session()->flush();          // Hapus semua isi data session
        $request->session()->invalidate();     // Matikan ID session
        $request->session()->regenerateToken(); // Ganti Token CSRF
        session_write_close();

        // 5. Tambahkan Header Prevent Cache agar browser tidak simpan halaman terakhir
        return Redirect::to('/')
            ->with('status', 'Akun dan semua data cache telah dibersihkan.')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }


    public function profileNormalisasi()
    {
        // dd(Auth::user()->id);
        return redirect(Route('profile.edit'));
    }
    public function based_user_data($idUser)
    {
        // dd($idUser);
        $user = User::find($idUser);
        // dd($user);
        // dd($user);
        // $user['role'] = [];
        $role[] = $user['tipe_pegawai'];

        $user['pegawai_detail'] = RiwayatNip::where('users_id', $idUser)
            ->where('is_active', 1)
            ->first();
        $user['emergency_contacts'] = \App\Models\Emergency_contact::where('users_id', $idUser)->get();
        // dd($user['emergency_contacts']);
        // dd($user,$idUser);
        // $user['pegawai_detail'] = RiwayatNip::where('users_id',$idUser)->first();
        $user['pegawai_detail']['status_pegawai'] = RefStatusPegawai::where('id', $user['pegawai_detail']['status_pegawai_id'])->first();
        if ($user['tipe_pegawai'] == "TPA") {
            $user['pegawai_detail']['data_tpa'] = Tpa::where('users_id', $idUser)->first();
        } else {
// <<<<<<< Updated upstream
            $user['pegawai_detail']['data_dosen'] = Dosen::with('serdos')->where('users_id', $idUser)->first();
// =======
            // $user['pegawai_detail']['data_dosen'] = Dosen::where('users_id', $idUser)->first();
// >>>>>>> Stashed changes
        }

        foreach ($user->jabatan as $jabatan) {
            $role[] = $jabatan->formasi->nama_formasi; // Memuat relasi formasi
        }
        // $rol[] =
        // dD($role);
        // dd($user->jabatan[0]->formasi->nama_formasi);
        $user['role'] = $role;
        return $user;
    }

    public function personalInfo($idUser)
    {
        // dd($idUser);

        $cek_exist_user = User::find($idUser);
        if(!$cek_exist_user){
            return ($this->handleRedirectBack())->with('error_alert', 'Data Tidak Ditemukan!.');
        }
        // dd($this->onlyOwnerAdminAndSdm($idUser));
        if ($this->onlyOwnerAdminAndSdm($idUser)==true) {
            // dd('masuk info');
            $user = $this->based_user_data($idUser);
            // dd($user);
            $route = view('kelola_data.pegawai.view.personal-information', compact('user'));
            return $this->CekReview($route, '1R1', 'MELIHAT PROFILE',true);
        }
        return redirect(route('profile.personal-info', ['idUser' => session('account')['id']]))->with('error_alert', 'Anda hanya boleh mengelola data anda sendiri!.');;


        // return $this->redirectDashboard();
    }

    // if ($this->onlyOwnerAdminAndSdm($idUser)==true) {

    //     }
    //     $route = redirect(route('profile.personal-info', ['idUser' => session('account')['id']]));

    public function changePassword($idUser)
    {
        // dd($this->onlyOwner($idUser)==true);
        if ($this->onlyOwner($idUser)==true) {
            // main code
            // return $this->redirectDashboard();
            $user = $this->based_user_data($idUser);
            return view('kelola_data.pegawai.view.change-password', compact('user'));
        }
        return redirect(route('profile.change-password', ['idUser' => session('account')['id']]));

        // return $this->redirectDashboard();
    }

    // if ($this->onlyOwnerAdminAndSdm($idUser)) {
    //         // main code
    //     } else if ($idUser == session('account')['id']) {
    //         // return redirect(route('profile.change-password', ['idUser' => $idUser]));
    //     }
    //     return $this->redirectDashboard();

    public function updatePassword(Request $request)
    {
        // dd($request);
        // $this->onlyOwner($request);

        $validated = $request->validate(
            [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
                'password_confirmation' => 'required_with:password',
                'same:password',
            ],
            [
                'current_password.required' => 'Password lama wajib diisi.',
                'current_password.current_password' => 'Password lama tidak sesuai.',
                'password.required' => 'Password baru wajib diisi.',
                'confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password baru minimal :min karakter.',
                'password.letters' => 'Password harus mengandung huruf besar dan huruf kecil.',
                'password.mixed' => 'Password harus mengandung huruf besar dan huruf kecil.',
                'password.numbers' => 'Password harus mengandung minimal satu angka.',
                'password.symbols' => 'Password harus mengandung minimal satu simbol.',
                'password.uncompromised' => 'Password terlalu umum dan tidak aman.',
            ]
        );



        $user = User::find(session('account')['id']);
        $user->password = $validated['password'];
        $user->is_new = false;
        $user->save();
        $route = ($this->handleRedirectBack())->with('success', 'Password berhasil diperbarui!');
        return $this->CekReview($route, '1R3', 'MENGUBAH PASSWORD');
    }

    // public function employeeInfo($idUser)
    // {
    //     if ($this->onlyOwnerAdminAndSdm($idUser)) {
    //         // main code
    //         $user = User::find($idUser);
    //         return view('kelola_data.pegawai.view.employee-information', compact('user'));
    //     } else if ($idUser == session('account')['id']) {
    //         // return redirect(route('profile.change-password', ['idUser' => $idUser]));
    //     }
    //     return $this->redirectDashboard();
    // }



    public function riwayatJabatan($idUser)
    {
        if ($this->onlyOwnerAdminAndSdm($idUser)) {
            // main code
            $user = User::find($idUser);
            // dd($user);

            return view('kelola_data.pegawai.view.riwayat-jabatan', compact('user'));
        }
        return redirect(route('profile.history.pemetaan', ['idUser' => $idUser]));
        return $this->redirectDashboard();
    }

    //SUDAH SEMUA DI DESITION TABLE
}
