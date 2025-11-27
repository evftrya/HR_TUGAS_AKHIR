<?php

namespace App\Http\Controllers;

use App\Models\Emergency_contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmergencyContactController extends Controller
{
    public function list($id_User)
    {
        // json_decode(pengawakan::with(['users', 'formasi', 'sk_ypt'])
        //             ->join('users', 'pengawakans.users_id', '=', 'users.id')
        //             ->orderBy('users.nama_lengkap', 'asc')
        //             ->select('pengawakans.*')
                    // ->get());
        $kontaks = Emergency_contact::where('users_id', $id_User)->get();
        $user = User::find($id_User);

        // dd($kontaks);
        return view('kelola_data.emergency_contact.list',compact('kontaks','user'));
    }

    public function new($id_User)
    {
        $user = User::find($id_User);

        return view('kelola_data.emergency_contact.input',compact('user'));
    }

    public function new_data(Request $request, $id_User)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:200',
            'status_hubungan' => 'required|string|max:255',
            'telepon'        => 'required|string|max:15',
            'email'          => 'required|email|max:100',
            'alamat'         => 'required|string|max:300',
        ],
        [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute maksimal :max karakter.',
            'string' => ':attribute harus berupa text.',
        ]);
        $validated['users_id'] = $id_User;

        DB::beginTransaction();
        
        // $validated['singkatan_level'] = strtoupper($validated['singkatan_level']);
        try {
            // $validated['work_position_id']=$validated['bagian'];
            $level = Emergency_contact::create($validated);
            DB::commit();
            // dd('done');
            return redirect(route('manage.emergency-contact.list', ['id_User' => $id_User]))->with('success', 'Emergency contact berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Kontak Darurat',
                'error' => $e->getMessage()
            ], 500);
        }

        // return redirect()->route('emergency-contacts.list', ['id_User' => $id_User])->with('success', 'Emergency contact added successfully.');
    }
}
