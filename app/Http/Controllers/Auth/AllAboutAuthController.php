<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

use Illuminate\View\View;

class AllAboutAuthController extends Controller
{
    public function send_verify($email_institusi)
    {
        try {
            $user = User::where('email_institusi', $email_institusi)->first();
            if ($user != null) {
                $otp = (string) random_int(100000, 999999);
                $user->verified_code = $otp;
                Mail::to($user->email_pribadi)->send(new SendEmail($otp));
                $user->save();

                return response()->json(['success' => true, 'data' => 'Berhasil membuat kode verifikasi'], 200);
            } else {
                throw new \Exception('Tidak ada akun dengan email institusi tersebut');
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    public function go_to_verify_page(Request $request)
    {
        try {
            $send_code = $this->send_verify($request->email_institusi);
            if ($send_code->getStatusCode() == 200) {
                return view('auth.verify-email-code')->with('message', 'Kode Verifikasi sudah berhasil dikirim ke email pribadi');
            } else {
                dd($send_code->getData(true));
                throw new \Exception($send_code->getData(true));
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    public function verifiy_code(Request $request)
    {
        try {
            // Validasi input
            $validated = $this->validation($request);

            $user = User::where('email_institusi', $request['email_institusi'])->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email_institusi' => ['Email tidak ditemukan.'],
                ]);
            }

            if ($user->verified_code === $request['otp']) {
                $user->email_verified_at = Carbon::now();
                $user->save(); // jangan lupa simpan perubahan
                return redirect('login')->with('message', 'Email berhasil divalidasi, silahkan login kembali');
            } else {
                throw ValidationException::withMessages([
                    'otp' => ['Kode verifikasi tidak sesuai.'],
                ]);
            }
        } catch (\Exception $e) {
            // Tangani error lain dengan lebih aman
            throw ValidationException::withMessages([
                'otp' => ['Terjadi kesalahan saat memverifikasi kode.'],
            ]);
        }
    }

    public function validation(Request $request)
    {
        return $request->validate(
            [
                'email_institusi' => [
                    'required',
                    'email',
                    'max:100',
                ],
                'otp' => [
                    'required',
                    'string',
                    'size:6',          // tepat 6 karakter
                    'regex:/^\d{6}$/', // hanya angka 0-9
                ],
            ],
            [
                'required' => ':attribute wajib diisi.',
                'max'      => ':attribute maksimal :max karakter.',
                'string'   => ':attribute harus berupa text.',
                'email.email' => 'Format Email Kontak Darurat tidak valid.',
                'size'     => ':attribute harus tepat :size karakter.',
                'regex'    => ':attribute harus berupa 6 digit angka.',
            ]
        );
    }
}
