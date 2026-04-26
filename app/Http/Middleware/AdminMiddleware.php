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
        // dd($roles, str_replace("|", ",", $roles),json_decode(str_replace("|", ",", $roles), true));
        $json_roles = json_decode(str_replace('|', ',', $roles), true);
        $user_role = session('account')['role'];
        // $this->role_user = session('account')['role'];
        // $this->json_roles = $json_roles;
        // foreach ($json_roles as $rules) {
        $result = false;

        // catatan
        // dump($json_roles, session('account')['role']);
        // dump(array_key_exists('and', $json_roles), '1');
        // dump(array_key_exists('bagian', $json_roles['and']), '2');
        // dump(isset($user_role[$json_roles['and']['bagian']]), '3');
        // dump(array_key_exists('range-level', $json_roles['and']), 4);
        // dump($user_role[$json_roles['and']['bagian']]['level'] >= $json_roles['and']['range-level'][0], 5, $user_role[$json_roles['and']['bagian']]['level'], $json_roles['and']['range-level'][0]);
        // dump($user_role[$json_roles['and']['bagian']]['level'] <= $json_roles['and']['range-level'][1], 6, $user_role[$json_roles['and']['bagian']]['level'], $json_roles['and']['range-level'][1]);
        // dump(array_key_exists('range-level', $json_roles), 7);
        // dump(isset($user_role['top-level']) && $user_role['top-level'] >= $json_roles['range-level'][0] && $user_role['top-level'] <= $json_roles['range-level'][1], 8);

        // $cekAdmin = array_key_exists('is_admin', $json_roles) && isset($user_role['is_admin']) && $user_role['is_admin'] == true;
        // $cekBagianWithRange = (array_key_exists('and', $json_roles) && array_key_exists('bagian', $json_roles['and']) && isset($user_role[$json_roles['and']['bagian']]) && array_key_exists('range-level', $json_roles['and']) && $user_role[$json_roles['and']['bagian']]['level'] >= $json_roles['and']['range-level'][0] && $user_role[$json_roles['and']['bagian']]['level'] <= $json_roles['and']['range-level'][1]);
        // $cekBagian = (array_key_exists('and', $json_roles) && array_key_exists('bagian', $json_roles['and']) && isset($user_role[$json_roles['and']['bagian']]));
        // $cekDosen = array_key_exists('is_dosen', $json_roles) && isset($user_role['is_dosen']) && $user_role['is_dosen'] == true;
        // $cekTpa = array_key_exists('is_tpa', $json_roles) && isset($user_role['is_tpa']) && $user_role['is_tpa'] == true;
        // $cekRangeLevel = array_key_exists('range-level', $json_roles) && isset($user_role['top-level']) && $user_role['top-level'] >= $json_roles['range-level'][0] && $user_role['top-level'] <= $json_roles['range-level'][1];

        // $result = false;
        if (array_key_exists('is_admin', $json_roles) && isset($user_role['is_admin']) && $user_role['is_admin'] == true) {
            return $next($request);

            // cek jika rules mewajibkan admin
        } elseif (array_key_exists('range-level', $json_roles) && isset($user_role['top-level']) && $user_role['top-level'] >= $json_roles['range-level'][0] && $user_role['top-level'] <= $json_roles['range-level'][1]) {
            return $next($request);

            // cek jika rules mewajibkan range level
        } elseif (array_key_exists('and', $json_roles) && array_key_exists('bagian', $json_roles['and']) && isset($user_role[$json_roles['and']['bagian']]) && array_key_exists('range-level', $json_roles['and']) && $user_role[$json_roles['and']['bagian']]['level'] >= $json_roles['and']['range-level'][0] && $user_role[$json_roles['and']['bagian']]['level'] <= $json_roles['and']['range-level'][1]) {
            return $next($request);

            // cek jika rules mewajibkan bagian tertentu with range level
        } elseif (array_key_exists('bagian', $json_roles)  && isset($user_role[$json_roles['bagian']])) {
            return $next($request);

            // cek jika rules mewajibkan bagian tertentu
        } elseif (array_key_exists('is_dosen', $json_roles) && isset($user_role['is_dosen']) && $user_role['is_dosen'] == true) {
            return $next($request);

            // cek jika rules mewajibkan dosen saja
            // # code...
        } elseif (array_key_exists('is_tpa', $json_roles) && isset($user_role['is_tpa']) && $user_role['is_tpa'] == true) {
            return $next($request);

            // cek jika rules mewajibkan tpa saja

        } else {
            return redirect()->back()->with('error_alert', 'Berdasarkan Hak Akses yang anda miliki, Anda tidak memiliki hak akses untuk mengakses halamaan yang dituju!.');
        }

        // dd($result);
        // return $next($request);

        // if ($result) {
        // } else {

        //     return redirect()->back()->with('error_alert', 'Anda tidak memiliki hak akses untuk mengakses halaman ini!.');
        // }

        // }

        // Jika tidak, redirect ke halaman home dengan pesan error
        // return redirect()->back()->with('error_alert', 'Anda tidak memiliki akses ke halaman ini.');

        // return redirect(route('login'))->with('error_alert', 'Silahkan Login Terlebih Dahulu.');
        // return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    // public function check()
    // {
    //     $json = $this->json_roles;
    //     $user = $this->role_user;
    //     if (array_key_exists('is_admin', $json)) {
    //         // $result = in_array('admin', $roles);
    //     }
    // }
}
