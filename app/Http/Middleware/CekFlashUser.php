<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekFlashUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(session('account'));
        $cek_flash = User::where('id', session('account')['id'])
            ->whereNotNull('flash')
            ->first();

        if ($cek_flash) {
            session(['notify' => $cek_flash->flash]);
            $cek_flash->flash = null;
            $cek_flash->save();
        }

        return $next($request);
    }
}
