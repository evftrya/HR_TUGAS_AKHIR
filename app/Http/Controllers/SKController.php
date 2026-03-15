<?php

namespace App\Http\Controllers;

use App\Models\RiwayatNip;
use App\Models\SK;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SKController extends Controller
{
    public function index()
    {
        $sk_all = SK::all();
        return view('kelola_data.sk.list', compact('sk_all'));
    }

    public function new(Request $request, $YptOrDikti, $fromWhere = null)
    {
        // $cek1 = $fromWhere;
        $validated = $request->validate([
            'tmt_mulai'     => ['required', 'date'],
            'file_sk'   => ['required', 'file', 'mimes:pdf,png,jpg,jpeg'],
            'no_sk'     => ['required', 'string', 'max:50'],
            'keperluan'     => ['required', 'string', 'max:50'],
            'keterangan'     => ['required', 'string', 'max:200'],
            // 'file_name'     => ['required', 'string', 'max:50'],

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
            // $validated['users_id'] = User::where('id', $request['users_id'])->first()['id'];
            // dd($users_id);
            $validated['tipe_sk'] = $YptOrDikti == 'YPT' ? 'Pengakuan YPT' : 'LLDIKTI';
            // $nip_user = RiwayatNip::where('users_id', $validated['users_id'])->where('is_active', 1)->first()['nip'];
            // dd($nip_user);
            // dd($request->file('file_sk'));
            // dd($request['file_sk']);
            $nama_file = $validated['keperluan'] . $validated['tipe_sk'] . "_" . pathinfo($validated['file_sk']->getClientOriginalName(), PATHINFO_FILENAME);
            // DB::commit();
            $ekstension = $validated['file_sk']->getClientOriginalExtension();
            $file_to_save = $validated['file_sk'];
            $validated['file_sk'] = null;
            $validated['file_sk'] = $nama_file  . "." . $ekstension;
            // dd($validated['file_sk'], 'cek');
            // dd($validated);
            // $validated['nip'] = RiwayatNip::where('nip', $nip_user)->first()->users_id;
            // dd($validated['users_id']);
            // $validated['keterangan'] = 'Jabatan Fungsional Pegawai';

            $sk = SK::create($validated);
            $validated['sk_pengakuan_ypt_id'] = $sk->id;
            DB::commit();
            // dd($validated['file_sk']);
            // $save = $file_to_save->store('SK/' . $this->formatStringToURL($validated['keperluan']), 'public');
            // $filename = time() . '.' . $file_to_save->getClientOriginalExtension();

            $save = $file_to_save->storeAs(
                'SK/' . $this->formatStringToURL($validated['keperluan']),
                $validated['file_sk'],
                'public'
            );

            if ($save == null) {
                throw new \Exception('Terjadi masalah ketika melakukan proses simpan foto, foto mungkin terlalu besar atau format tidak sesuai');
            }

            if ($fromWhere === null) {
                // dd('masuk',$cek1,$cek2,$fromWhere==null);
                return redirect()->back()->with('success', 'SK ' . $YptOrDikti . ' Berhasil Ditambahkan');
            } else {
                // return $sk->id;
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil membuat SK',
                    'data' => $sk
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat SK',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function formatStringToURL($text)
    {
        // Hilangkan spasi depan dan belakang
        $text = trim($text);

        // Ganti satu atau lebih spasi di tengah menjadi _
        $text = preg_replace('/\s+/', '_', $text);

        return $text;
    }
}
