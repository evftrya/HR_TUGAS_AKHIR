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
        if (array_key_exists('is_admin', $json_roles) && in_array('admin', $user_role)) {
            $result = in_array('admin', $user_role);
            // dump('admin', $result);
        } elseif (array_key_exists('and', $json_roles)) {
            $found = in_array(
                $json_roles['and']['bagian'],
                array_column(
                    array_filter($json_roles, 'is_array'),
                    'bagian'
                )
            );
            $result = $found;
        }
        else{
            return redirect()->back()->with('error_alert', 'Anda tidak memiliki hak akses untuk mengakses halaman ini!.');
        }


        // dd($json_roles, session('account')['role'], $result, array_key_exists('and', $json_roles));
        // }

        return $next($request);

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
