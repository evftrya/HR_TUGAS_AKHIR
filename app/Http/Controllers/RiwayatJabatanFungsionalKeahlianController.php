<?php

namespace App\Http\Controllers;

use App\Models\riwayatJabatanFungsionalKeahlian;
use App\Models\SK;
use App\Models\Tpa;
use Illuminate\Http\Request;

class RiwayatJabatanFungsionalKeahlianController extends Controller
{
    public function index()
    {
        $jfks = riwayatJabatanFungsionalKeahlian::all();

        return view('kelola_data.jfk.list',compact('jfks'));
    }
    public function new()
    {
        $jfks = riwayatJabatanFungsionalKeahlian::all()->sortBy('nama_jfk')->values();
        $tpa = Tpa::with('pegawai')->get()->sortBy('pegawai.nama_lengkap')->values();
        $sk = SK::all()->sortBy('nomor_sk')->values();

        return view('kelola_data.jfk.input', compact('jfks', 'tpa', 'sk'));
    }
}
