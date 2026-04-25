<?php

namespace App\Http\Controllers;

use App\Models\RefResearchCoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefResearchCoeController extends Controller
{
    public function list()
    {
        $data = RefResearchCoe::all()->sortBy('nama');
        return view('kelola_data.coe.ref-research.list', compact('data'));
    }

    public function new()
    {
        return view('kelola_data.coe.ref-research.input');
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
