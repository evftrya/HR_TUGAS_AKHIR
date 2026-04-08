<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        // dd($roles);
        $all_role = explode(',', $roles);
        dd(in_array(['admin','Tpa'], $all_role), $all_role,['admin','Tpa'], array_intersect($all_role, ['admin','Tpa']));
        // dd('masuk admin');
        // Cek apakah user sudah login DAN user adalah admin
        if (Auth::check() && in_array(['admin','Tpa'], $all_role)) {
            // Jika ya, lanjutkan request
            return $next($request);
        }

        // Jika tidak, redirect ke halaman home dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    
}
