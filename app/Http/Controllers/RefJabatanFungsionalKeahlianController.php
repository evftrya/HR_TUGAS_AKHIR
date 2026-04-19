<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefJabatanFungsionalKeahlianController extends Controller
{
    public function list()
    {
        return view('kelola_data.jfk.ref.list');
    }

    public function new()
    {
        return view('kelola_data.jfk.ref.new');
    }

    public function store(Request $request) {}

    public function edit()
    {
        return view('kelola_data.jfk.ref.edit');
    }

    public function update(Request $request) {}

    public function validation() {}
}
