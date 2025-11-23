<?php

namespace App\Http\Controllers;

use App\Models\pengawakan;
use App\Models\SK;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PengawakanController extends Controller
{
    public function index()
    {
        // $formations = json_decode(Formation::with(['bagian', 'prodi', 'fakultas','level_id','atasan_formation'])
        //                             ->orderBy('atasan_formasi_id')
        //                             ->get());
        $pemetaans = json_decode(pengawakan::with(['users', 'formasi', 'sk_ypt'])
                    ->join('users', 'pengawakans.users_id', '=', 'users.id')
                                    ->where('tmt_selesai',null)

                    ->orderBy('users.nama_lengkap', 'asc')
                    ->select('pengawakans.*')
                    ->get());
        // dd($pemetaans);

        // dd('masuk');
        
            // return view('kelola_data.fakultas.list',compact('send'));
            return view('kelola_data.sotk-pengawakan.list',compact('pemetaans'));
    }

    public function new()
    {
        $users = \App\Models\User::all()->sortBy('nama_lengkap');
        $formations = \App\Models\formation::all()->sortBy('nama_formasi');
        $sk_ypts = \App\Models\SK::all()->where('tipe_sk','Pengakuan YPT')->sortBy('no_sk');
        // dd($sk_ypts);

        return view('kelola_data.sotk-pengawakan.input', compact('users', 'formations', 'sk_ypts'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        // dd($request);
        $validated = $request->validate([
            'users_id'   => ['required'],
            'formasi_id' => ['required'],
            'sk_ypt_id'  => ['nullable', 'required_without_all:file_sk,no_sk'],
            'tmt_mulai'  => ['required','date'],
            'file_sk'    => ['nullable','file','mimes:pdf,png,jpg,jpeg','required_without:sk_ypt_id'],
            'no_sk'      => ['nullable','string','max:50','required_without:sk_ypt_id'],
        ], [
            'required' => ':attribute wajib diisi.',
            'date'     => ':attribute harus berupa tanggal yang valid.',

            // pakai :values, bukan :other
            'required_without'      => ':attribute wajib diisi jika :values tidak ada.',
            'required_without_all'  => ':attribute wajib diisi jika :values tidak ada semuanya.',
        ], [
            // optional: ganti nama attribute biar rapi
            'sk_ypt_id' => 'SK YPT',
            'file_sk'   => 'file SK',
            'no_sk'     => 'nomor SK',
        ]);

        if($validated['no_sk']!=null){
            $validated['sk_ypt_id'] = null;
        }

        // dd($validated);

        DB::beginTransaction();
        // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {

            if($validated['sk_ypt_id']==null){
                // dd('masuk');

                try {

                    $validated['tipe_sk'] = 'Pengakuan YPT';
                    $sk = SK::create($validated);
                    // DB::commit();
                    $validated['sk_ypt_id'] = $sk->id;

                } catch (\Exception $e) {
                    // DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat SK YPT',
                        'error' => $e->getMessage()
                    ], 500);
                }
                // $validated['users_id'] = $request->users_id;
                
            }
            // $level = Formation::create($validated);
            pengawakan::create($validated);

            DB::commit();
            // dd('done');
            return redirect(route('manage.pengawakan.list'))->with('success', 'Pengawakan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Formasi',
                'error' => $e->getMessage()
            ], 500);
        }

        // dd('masuk');


        // return redirect()->route('pengawakan.list')->with('success', 'Data pengawakan berhasil ditambahkan.');
    }

    public function update($idPemetaan)
    {
        $Pemetaan = pengawakan::findOrFail($idPemetaan);
        $users = \App\Models\User::all()->sortBy('nama_lengkap');
        $formations = \App\Models\formation::all()->sortBy('nama_formasi');
        $sk_ypts = \App\Models\SK::all()->where('tipe_sk','Pengakuan YPT')->sortBy('no_sk');
        // dd($Pemetaan);

        return view('kelola_data.sotk-pengawakan.update', compact('users', 'formations', 'sk_ypts','Pemetaan'));   
    }

    public function update_data(Request $request, $idPemetaan)
    {
        // dd($request->all());
        $validated = $request->validate([
            'users_id'   => ['required'],
            'formasi_id' => ['required'],
            'sk_ypt_id'  => ['nullable', 'required_without_all:file_sk,no_sk'],
            'tmt_mulai'  => ['required','date'],
            'file_sk'    => ['nullable','file','mimes:pdf,png,jpg,jpeg','required_without:sk_ypt_id'],
            'no_sk'      => ['nullable','string','max:50','required_without:sk_ypt_id'],
        ], [
            'required' => ':attribute wajib diisi.',
            'date'     => ':attribute harus berupa tanggal yang valid.',

            // pakai :values, bukan :other
            'required_without'      => ':attribute wajib diisi jika :values tidak ada.',
            'required_without_all'  => ':attribute wajib diisi jika :values tidak ada semuanya.',
        ], [
            // optional: ganti nama attribute biar rapi
            'sk_ypt_id' => 'SK YPT',
            'file_sk'   => 'file SK',
            'no_sk'     => 'nomor SK',
        ]);

        if($validated['no_sk']!=null){
            $validated['sk_ypt_id'] = null;
        }

        $Pemetaan = pengawakan::findOrFail($idPemetaan);
        $Pemetaan->update($validated);

        return redirect()->route('manage.pengawakan.list')->with('success', 'Data pengawakan berhasil diperbarui.');
    }

    public function history_pemetaan($id_user)
    {
        $user = User::find($id_user);
        $user['pengawakans'] = pengawakan::with(['formasi.bagian','formasi.level_data', 'sk_ypt'])
                                    ->where('users_id', $id_user)
                                    ->orderBy('tmt_mulai', 'desc')
                                    ->get();
        $user['pengawakans_aktif'] = pengawakan::with(['formasi.bagian','formasi.level_data', 'sk_ypt'])
                                    ->where('users_id', $id_user)
                                    ->whereNull('tmt_selesai')
                                    ->orderBy('tmt_mulai', 'desc')
                                    ->get();

        // dd($user['pengawakans_aktif']);
        return view('kelola_data.pegawai.view.riwayat-jabatan',compact('user'));

    }

    public function end_pemetaan(Request $request){
        DB::beginTransaction();

        try {

            $pemetaan = pengawakan::findOrFail($request->id);
            $pemetaan->tmt_selesai = now()->format('Y-m-d H:i:s');
            $pemetaan->save();

            DB::commit();
            return redirect()->route('manage.pengawakan.list')->with('success', 'Pemetaan berhasil dinonaktifkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Menonaktifkan Pemetaan',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
