<?php

namespace App\Http\Controllers;

use App\Models\riwayatJabatanFungsionalKeahlian;
use Illuminate\Http\Request;

class RiwayatJabatanFungsionalKeahlianController extends Controller
{
    public function index()
    {
        $jfks = riwayatJabatanFungsionalKeahlian::all();

        return view('kelola_data.jfa.list',compact('jfks'));
    }
}
