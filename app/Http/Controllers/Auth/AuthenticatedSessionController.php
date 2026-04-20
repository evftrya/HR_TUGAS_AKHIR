<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
// use App\Models\TestingSIMDK;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {

            // $cek1 = session('account');

            // Attempt authentication
            $request->authenticate();
            // dd($request->authenticate());

            // $cek2 = session('account');

            // regenerate session
            $request->session()->regenerate();

            // $cek3 = session('account');

            $user = Auth::user();

            // $cek4 = session('account');

            // dd($cek1,$cek2,$cek3,$cek4,'cek ini');

            if (!$user) {

                Log::error('No user after authentication');

                return redirect()->route('login');
            }

            $type = \App\Models\Tpa::where('users_id', $user->id)->exists() ? 'TPA' : 'Dosen';
            $role = [];
            $role[] = $type;
            // dd($user);
            if ($user->is_admin == 1) {
                $role[] = 'admin';
            }

            //get all the role  by work position
            // $role_pemetaan = DB::table('users as a')
            //     ->join('pengawakans as b', 'b.users_id', '=', 'a.id')
            //     ->join('formations as c', 'c.id', '=', 'b.formasi_id')
            //     ->join('levels as d', 'd.id', '=', 'c.level_id')
            //     ->join('work_positions as e', 'e.id', '=', 'c.work_position_id')
            //     ->select('d.urut as tingkat','d.singkatan_level as level', 'e.kode as bagian')
            //     ->where('b.tmt_selesai', '>=', now())
            //     ->where('a.id', '69dcfd44-965e-4c58-9cad-639b70c46369')
            //     ->get()->toArray();
            // $data_array = collect($role_pemetaan)->map(function ($item) {
            //     return (array) $item;
            // })->toArray();
            // $role[] = $data_array;
            // dd($role_pemetaan, $role);



            // dd($user);
            // $is_admin = \App\Models\Tpa::where('users_id', $user->id)['is_admin']==1?'Admin':null;
            $sessionData = array_merge(
                $user->toArray(),
                ['role' => $role]
            );



            // $sessionData = $role;



            session(['account' => $sessionData]);
            // dd(session('account'));

            Log::info('Login successful', [
                'user_id' => $user->id,
                'session_id' => session()->getId()
            ]);


            $cek_testing = TestingSIMDK::where('users_id', $user->id)->first();
            // dd($cek_testing);
            // dd($cek_testing);
                // Log::info('cek testing'. $cek_testing==NULL);
            



            // dd($user,$user->is_new==true ,$user->is_new===1,$user->is_new==1);
            if ($user->is_new == 1) {
                Log::info('Redirecting to change password for new user.');
                $route = redirect(route('profile.change-password', ['idUser' => session('account')['id']]))->with('message', 'Karena akun Anda baru dibuat, silakan ubah kata sandi Anda terlebih dahulu demi keamanan akun Anda.');
                if ($cek_testing==null) {
                    $route->with('testing', 'Login');
                }
                return $route;
            } else {
                Log::info('Pengguna telah berhasil login ke sistem 2.');
                $route = redirect()->route('dashboard')
                    ->withCookie(cookie()->forever('auth_check', true));
                if ($cek_testing==null) {
                    $route->with('testing', 'Login');
                }else{
                    $route->with('message', 'Login Berhasil!');
                }
                return $route;
            }
        } catch (\Exception $e) {

            Log::error('Login exception', ['error' => $e->getMessage()]);

            return redirect()->route('login')
                ->withErrors([
                    // 'email_institusi' => 'Login failed',
                    $e->getMessage(),
                ])
                ->withInput();
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
