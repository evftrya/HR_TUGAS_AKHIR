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

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }



    /**
     * Update the user's profile information.
     */
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
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
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
            $user['pegawai_detail']['data_dosen'] = Dosen::where('users_id', $idUser)->first();
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
        $user = $this->based_user_data($idUser);
        // dd($user);
        return view('kelola_data.pegawai.view.personal-information', compact('user'));
    }

    public function changePassword($idUser)
    {
        $user = $this->based_user_data($idUser);
        return view('kelola_data.pegawai.view.change-password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate(
            [
                'current_password' => ['required', 'current_password'],
                'password' => ['required','confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
                'password_confirmation' => 'required_with:password','same:password',
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
        $user->save();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Password berhasil diperbarui!'
        // ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    public function employeeInfo($idUser)
    {
        $user = User::find($idUser);
        return view('kelola_data.pegawai.view.employee-information', compact('user'));
    }



    public function riwayatJabatan($idUser)
    {
        $user = User::find($idUser);
        dd($user);

        return view('kelola_data.pegawai.view.riwayat-jabatan', compact('user'));
    }
}
