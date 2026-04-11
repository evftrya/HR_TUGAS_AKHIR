<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefSubKelompokKeahlianController extends Controller
{
    public function index(){
        return view('kelola_data.kelompok_keahlian.sub.list');
    }
}
