<?php

namespace App\Http\Controllers;

use App\Models\RefStatusPegawai;
use App\Models\SK;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatNipController extends Controller
{
    public function index()
    {
        // $jfks = riwayatJabatanFungsionalKeahlian::all();
        // return view('kelola_data.jfa.list',compact('jfks'));
        return view('kelola_data.riwayat-nip.list');
    }

    public function new()
    {
        $users = User::all()->sortBy('nama_lengkap');
        $sk_ypts = SK::Sk_Ypt();
        // dd($sk_ypts);
        $status_pegawai = RefStatusPegawai::all()->sortBy('status_pegawai');
        return view('kelola_data.riwayat-nip.input',compact('users','sk_ypts','status_pegawai'));
    }
}
