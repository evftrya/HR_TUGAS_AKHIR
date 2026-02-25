<?php

namespace App\Http\Controllers;

use App\Models\Emergency_contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class EmergencyContactController extends Controller
{
    /**
     * Helper untuk membersihkan cache kontak darurat user tertentu.
     */
    private function clearEmergencyCache($id_User)
    {
        Cache::forget("emergency_contacts_user_{$id_User}");
    }

    public function list($id_User)
    {
        /**
         * Caching daftar kontak darurat.
         * Kita gunakan key unik per user agar data antar pegawai tidak tertukar.
         */
        $kontaks = Cache::remember("emergency_contacts_user_{$id_User}", 3600, function () use ($id_User) {
            return Emergency_contact::where('users_id', $id_User)->get();
        });

        /**
         * Optimasi: Jangan instansiasi Controller lain di dalam method jika hanya butuh data.
         * Jika ProfileController->based_user_data() melakukan query berat, sebaiknya ditarik ke cache juga.
         */
        $user = (new ProfileController)->based_user_data($id_User);

        return view('kelola_data.emergency_contact.list', compact('kontaks', 'user'));
    }

    public function new($id_User)
    {
        $user = (new ProfileController)->based_user_data($id_User);
        return view('kelola_data.emergency_contact.input', compact('user'));
    }

    public function new_data(Request $request, $id_User)
    {
        $validated = $request->validate(
            [
                'nama_lengkap'    => 'required|string|max:200',
                'status_hubungan' => 'required|string|max:255',
                'telepon'         => 'required|string|max:15',
                'email'           => 'required|email|max:100',
                'alamat'          => 'required|string|max:300',
            ],
            [
                'required' => ':attribute wajib diisi.',
                'max'      => ':attribute maksimal :max karakter.',
                'string'   => ':attribute harus berupa text.',
            ]
        );
        
        $validated['users_id'] = $id_User;

        DB::beginTransaction();

        try {
            Emergency_contact::create($validated);
            
            DB::commit();

            // PENTING: Hapus cache setelah menambah data baru agar list terupdate
            $this->clearEmergencyCache($id_User);

            return redirect(route('manage.emergency-contact.list', ['id_User' => $id_User]))
                ->with('success', 'Emergency contact berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Kontak Darurat',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}