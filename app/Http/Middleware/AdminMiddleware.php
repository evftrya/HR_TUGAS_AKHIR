<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public array $role_user = [];

    public array $json_roles = [];

    public function handle(Request $request, Closure $next, $roles): Response
    {
        $json_roles = json_decode(str_replace('|', ',', $roles), true);
        
        if($json_roles == null){
            return ($this->handleRedirectBack())->with('error_alert', 'Terjadi Kesalahan Sistem Dalam membaca aturan Hak Akses!.');
        }
        
        $user_role = session('account')['role'] ?? [];
        
        if (array_key_exists('is_admin', $json_roles) && isset($user_role['is_admin']) && $user_role['is_admin'] == true) {
            return $next($request);
        } elseif (array_key_exists('range-level', $json_roles) && isset($user_role['top-level']) && $user_role['top-level'] >= $json_roles['range-level'][0] && $user_role['top-level'] <= $json_roles['range-level'][1]) {
            return $next($request);
        } elseif (array_key_exists('and', $json_roles) && array_key_exists('bagian', $json_roles['and']) && isset($user_role[$json_roles['and']['bagian']]) && array_key_exists('range-level', $json_roles['and']) && $user_role[$json_roles['and']['bagian']]['level'] >= $json_roles['and']['range-level'][0] && $user_role[$json_roles['and']['bagian']]['level'] <= $json_roles['and']['range-level'][1]) {
            return $next($request);
        } elseif (array_key_exists('bagian', $json_roles)  && isset($user_role[$json_roles['bagian']])) {
            return $next($request);
        } elseif (array_key_exists('is_dosen', $json_roles) && isset($user_role['is_dosen']) && $user_role['is_dosen'] == true) {
            return $next($request);
        } elseif (array_key_exists('is_tpa', $json_roles) && isset($user_role['is_tpa']) && $user_role['is_tpa'] == true) {
            return $next($request);
        } else {
            return ($this->handleRedirectBack())->with('error_alert', 'Mohon maaf, Anda belum memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda memerlukan akses lebih lanjut!.');
        }
    }

    public function handleRedirectBack()
    {
        $current = url()->current();
        $previous = url()->previous();

        if ($current === $previous || $previous === url('/testForm')) {
            return redirect()->route('dashboard');
        }

        return redirect()->back();
    }
}
