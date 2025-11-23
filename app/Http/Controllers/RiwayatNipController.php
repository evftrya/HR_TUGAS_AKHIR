<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatNipController extends Controller
{
    public function index()
    {
        // $jfks = riwayatJabatanFungsionalKeahlian::all();
        // return view('kelola_data.jfa.list',compact('jfks'));
        return view('kelola_data.riwayat-nip.list');
    }
}
