<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

abstract class Controller
{

    public function formatStringToURL($text)
    {
        // Hilangkan spasi depan dan belakang
        $text = trim($text);

        // Ganti satu atau lebih spasi di tengah menjadi _
        $text = preg_replace('/\s+/', '_', $text);

        return $text;
    }

    public function onlyOwnerAndAdmin($id = null)
    {
        // dd($id,session('account')['id'] == $id,session('account')['id']);
        $is_admin = session('account')['is_admin'] == 1;
        // dd($is_admin);
        // dd($is_admin,'cek');
        $is_owner = null;

        $result = $is_admin;
        if ($id != null) {
            // dd('masuk');
            $is_owner = session('account')['id'] == $id;
            $result =  ($is_admin || $is_owner);
            // dd($result);
        }


        // dd($result == true);
        // dd($result);
        return $result;
    }

    public function onlyOwner($id)
    {
        // dd(session('account')['id'], $id);
        // dd($id,session('account')['id'] == $id,session('account')['id']);
        $is_owner = session('account')['id'] == $id;

        return $is_owner;
    }





    public function redirectDashboard()
    {
        return redirect(route('dashboard'))->with('error', 'Halaman ini tidak tersedia untuk anda');
    }

    public function MakeLog($keterangan, $tambahan = null)
    {
        return Log::info($keterangan, [
            'id' => session('account')['id'],
            'email' => session('account')['email_institusi'],
            'session_id' => Session::getId(),
            'tambahan' => $tambahan
        ]);
    }

    public function CekReview($route_normal, $kode_review, $name_review)
    {
        if (config('app.testing_mode') === true) {
            $cek_review = (new TestingSIMDKController())->cek_review($kode_review);
            if ($cek_review == false) {
                // dd('masuk 2 cont');
                $this->MakeLog('User Dianjurkan Mengisi Review terkait kode ' . $kode_review . ' tentang ' . $name_review);
                $new_route = $route_normal->with('testing', ['kode' => $kode_review, 'name' => $name_review]);
                // dd($new_route);
                return $new_route;
            } else {
                // dd('masuk 3 cont');
                return $route_normal;
            }
        } else {
            // dd('masuk 4 cont');
            return $route_normal;
        }
    }
}
