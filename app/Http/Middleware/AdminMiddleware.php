<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        // dd($roles);
        if (Auth::check()) {
            // dd('out');
            $exp_roles =  explode('|', $roles);
            $roles_condition = array_map(function ($item) {
                return is_string($item) ? strtolower(trim($item)) : $item;
            }, $exp_roles);

            $user_roles = session('account')['role'];

            $roles_user = array_map(function ($item) {
                return is_string($item) ? strtolower(trim($item)) : $item;
            }, $user_roles);

            // dd( $roles_user, $roles_condition);
            // dd(array_intersect($roles_condition, $roles_user)!=null,in_array('own', $roles_user), $roles_user, $roles_condition);
            // dd($roles_condition, $roles_user);
            // dd(array_intersect($roles_condition, $roles_user));
            if ((Auth::check() && (array_intersect($roles_condition, $roles_user) != null))||in_array('own', $roles_condition)) {
                // dd('masuk');
                // dd('kfjg');
                return $next($request);
            }

            // Jika tidak, redirect ke halaman home dengan pesan error
            return redirect()->back()->with('error_alert', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return redirect(route('login'))->with('error_alert', 'Silahkan Login Terlebih Dahulu.');
        // return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
