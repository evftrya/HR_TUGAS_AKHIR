<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefJabatanFungsionalAkademikController extends Controller
{
    public function list()
    {
        return view('kelola_data.jfa.ref.list');
    }

    public function new()
    {
        return view('kelola_data.jfa.ref.new');
    }

    public function store(Request $request) {}

    public function edit()
    {
        return view('kelola_data.jfa.ref.edit');
    }

    public function update(Request $request) {}

    public function validation() {}
}
