<?php

namespace App\Http\Controllers;

use App\Models\riwayatJabatanFungsionalAkademik;
use Illuminate\Http\Request;

class RiwayatJabatanFungsionalAkademikController extends Controller
{
    public function index()
    {
        $jfas = riwayatJabatanFungsionalAkademik::all();

        return view('kelola_data.jfa.list',compact('jfas'));
    }
}
