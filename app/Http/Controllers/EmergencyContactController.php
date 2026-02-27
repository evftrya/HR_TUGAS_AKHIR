<?php

namespace App\Http\Controllers;

use App\Models\Emergency_contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


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
        $validated = $this->validation($request);

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

    public function validation(Request $request)
    {
        return $request->validate(
            [
                'nama_lengkap' => [
                    'required',
                    'string',
                    'max:200',
                    "regex:/^(?=.*[A-Za-z])[A-Za-z' ]+$/"
                ],
                'status_hubungan' => 'required|string|max:255',
                'telepon'         => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/^(?![ +-])(?!.*\+\+)(?!.*--)(?=.*\d)[0-9+\- ]+$/'
                ],
                'email'           => 'required|email|max:100',
                'alamat'          => 'required|string|max:300',
            ],
            [
                'required' => ':attribute wajib diisi.',
                'max'      => ':attribute maksimal :max karakter.',
                'string'   => ':attribute harus berupa text.',
                'nama_lengkap.regex' => 'Nama Lengkap hanya boleh berisi huruf, spasi, dan tanda petik (\') serta harus mengandung minimal 1 huruf.',
                'telepon.regex'      => 'Telepon hanya boleh berisi angka, spasi, tanda + dan -, tidak boleh diawali spasi atau -, dan harus mengandung angka.',
            ]
        );
    }

    public function updateView($id_User, $id_emergency_contact)
    {
        // dd($id_emergency_contact,$id_User);
        $ec = Emergency_contact::where('id', $id_emergency_contact)->first();
        $user = (new ProfileController)->based_user_data($id_User);
        return view('kelola_data.emergency_contact.update', ['data' => $ec, 'user' => $user]);
    }

    public function updateData(Request $request, $id_User, $id_emergency_contact)
    {
        $validated = $this->validation($request); // Ambil data tervalidasi

        $ec = Emergency_contact::where('id', $id_emergency_contact)->first();

        DB::beginTransaction(); // Tambahkan transaction agar lebih aman

        try {
            if (!$ec) {
                throw new \Exception('Data Emergency Contact tidak ditemukan.');
            }

            // Update menggunakan data tervalidasi
            $ec->update($validated);

            DB::commit();

            // --- BAGIAN PENTING: Hapus Cache ---
            $this->clearEmergencyCache($id_User);
            // ------------------------------------

            if (session('account')['is_admin'] && $id_User != session('account')['id']) {
                return redirect(route('manage.emergency-contact.list', ['id_User' => $id_User]))
                    ->with('success', 'Kontak darurat berhasil diperbarui.');
            } else {
                return redirect(route('profile.emergency-contacts.list', ['id_User' => session('account')['id']]))
                    ->with('success', 'Kontak darurat berhasil diperbarui.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update emergency contact: ' . $e->getMessage());

            return redirect()->back()
                ->with('message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
