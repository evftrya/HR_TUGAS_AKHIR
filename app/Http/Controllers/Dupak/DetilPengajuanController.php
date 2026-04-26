<?php

namespace App\Http\Controllers\Dupak;

use App\Http\Controllers\Controller;
use App\Models\Dupak\Pengajuan;
use Illuminate\Http\Request;

class DetilPengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // The view folder uses underscores (pengisian_detil_pengajuan). Return the correct view.
        return view('dupak.pengisian_detil_pengajuan.create');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $getPengajuan = Pengajuan::find($id);
        if (!$getPengajuan) {
            return ($this->handleRedirectBack())->with('error', 'Pengajuan not found.');
        }
        $id = $getPengajuan->id;
        return view('dupak.pengisian_detil_pengajuan.show', ['id' => $id]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }
}
