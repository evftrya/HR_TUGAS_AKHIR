<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenHasCOEController extends Controller
{
    public function list() {
        return view('kelola_data.coe.dosen-has-coe.list');
    }

    public function new() {
        return view('kelola_data.coe.dosen-has-coe.input');
    }

    public function create(Request $request)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);

        try {
            DB::beginTransaction();
            $save = '';
            if (! $save) {
                throw new \Exception('Gagal menyimpan data!.');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->with('error_alert', $e->getMessage());
        }
    }

    public function edit() {}

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validation()[0], $this->validation()[1], $this->validation()[2]);

    }

    public function validation()
    {
        return [

        ];
    }
}
