<?php

namespace App\Http\Controllers;

use App\Models\RiwayatNip;
use App\Models\SK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SKController extends Controller
{
    public function index()
    {
        // $jfks = riwayatJabatanFungsionalKeahlian::all();
        // return view('kelola_data.jfa.list',compact('jfks'));
        return view('kelola_data.sk.list');
    }

    public function new(Request $request, $YptOrDikti, $fromWhere=null)
    {
        $validated = $request->validate([
            'tmt_mulai'     => ['required', 'date'],
            'file_sk'   => ['required', 'file', 'mimes:pdf,png,jpg,jpeg'],
            'no_sk'     => ['required', 'string', 'max:50'],
            'keperluan'     => ['required', 'string', 'max:50'],
            'file_name'     => ['required', 'string', 'max:50'],

        ], [

            'required' => ':attribute wajib diisi.',
            'date'     => ':attribute harus berupa tanggal yang valid.',

        ], [

            'file_sk'           => 'file SK YPT',
            'no_sk'             => 'Nomor SK YPT',
        ]);


        DB::beginTransaction();

        try {
            // $validated['no_sk'] = $validated['no_sk_ypt'];
            $nip_user = explode("_", $validated['file_name'])[0];
            $validated['tipe_sk'] = $YptOrDikti=='YPT' ? 'Pengakuan YPT' : 'LLDIKTI';
            $nama_file = $validated['keperluan']."_".$validated['file_name']."|".$validated['tipe_sk'];
            // DB::commit();
            $validated['file_sk'] = $nama_file;
            $validated['users_id'] = RiwayatNip::where('nip', $nip_user)->first()->users_id;
            // dd($validated['users_id']);
            $sk = SK::create($validated);
            $validated['sk_pengakuan_ypt_id'] = $sk->id;
            DB::commit();

            if($fromWhere==null){
                return redirect()->back()->with('success', 'SK '.$YptOrDikti.' Berhasil Ditambahkan');
            }
            else{
                return $sk->id;
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat SK LLDIKTI',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
