<?php

namespace App\Http\Controllers;

use App\Models\Emergency_contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmergencyContactController extends Controller
{
    public string $aksi = 'Emergency Contact';

    /**
     * Method helper clear cache dihapus karena sudah tidak menggunakan caching.
     */
    public function list($id_User)
    {
        $cek_user = User::where('id', $id_User)->first();
        // dd($cek_user);
        if (! $cek_user) {
            return $this->handleRedirectBack()->with('error_alert', 'User tidak ditemukan!.');
        }
        if ($this->onlyOwnerAdminAndSdm($id_User) == true) {
            // dd($id_User);
            /**
             * Mengambil data langsung dari database tanpa Cache.
             */
            $kontaks = Emergency_contact::where('users_id', $id_User)->get();
            // dd($id_User);
            $user = (new ProfileController)->based_user_data($id_User);

            $this->MakeLog('User Berhasil Mengakses halaman List '.$this->aksi);

            return view('kelola_data.emergency_contact.list', compact('kontaks', 'user'));
        }

        // dd('masuk');
        return redirect(route('profile.emergency-contacts.list', ['id_User' => session('account')['id']]))->with('error_alert', 'Anda hanya boleh menambahkan data anda sendiri!.');
    }

    public function new($id_User)
    {
        // dd('kjsdz,d');
        // dd($id_User);
        $cek_user = User::where('id', $id_User)->first();
        if (! $cek_user) {
            return $this->handleRedirectBack()->with('error_alert', 'User tidak ditemukan!.');
        }
        if ($this->onlyOwnerAdminAndSdm($id_User) == true) {
            // dd('masuksd');

            $user = (new ProfileController)->based_user_data($id_User);
            $this->MakeLog('User Berhasil Mengakses halaman Tambah Data '.$this->aksi);
            $route = view('kelola_data.emergency_contact.input', compact('user'));

            return $this->CekReview($route, '1E1', 'MELIHAT DATA EMERGENCY KONTAK');
        }

        return redirect(route('profile.emergency-contacts.new',
            ['id_User' => session('account')['id']]))
            ->with('error_alert', 'Anda hanya boleh menambahkan data anda sendiri!.');
    }

    public function new_data(Request $request, $id_User)
    {
        $cek_user = User::where('id', $id_User)->first();
        if (! $cek_user) {
            return $this->handleRedirectBack()->with('error_alert', 'User tidak ditemukan!.');
        }
        if ($this->onlyOwnerAdminAndSdm($id_User) == true) {

            try {
                $validation = $this->validation();
                $validated = $request->validate($validation[0],$validation[1],$validation[2]);
                // dd($validated);
                $validated['users_id'] = $id_User;
                // dump($validated['telepon']);
                $cek_number = Emergency_contact::where('telepon', $validated['telepon'])->where('users_id', $validated['users_id'])->first();
                // dump('aksjhdkajs');
                // dd($cek_number);

                if ($cek_number) {
                    throw new \Exception('Nomor Emergency dengan Pegawai Ini Sudah Terdaftar, Coba yang Lain!.');
                }

                // Memanggil method create di bawah
                $save = $this->create(new Request($validated));
                $this->MakeLog('User Berhasil Mengakses Menambahkan Data '.$this->aksi, ['data' => $save]);

                $route = session('account')['is_admin']==1 && $id_User != session('account')['id']
                        ? route('manage.emergency-contact.list',['id_User' => $id_User])
                        : route('profile.emergency-contacts.list',['id_User' => $id_User]);
                return redirect($route)
                    ->with('success', 'Emergency contact berhasil dibuat.');
            } catch (\Exception $e) {
                // Rollback jika terjadi error pada database di method create
                DB::rollBack();
                // dd($e->getMessage());
                $route = $this->handleRedirectBack()->withInput($request->all())->with('error_alert', 'Emergency contact Gagal Dibuat, Berikut alannya: '.$e->getMessage());

                return $this->CekReview($route, '1E3', 'MENAMBAH DATA EMERGENCY KONTAK');
            }
        }

        return redirect(route('profile.emergency-contacts.new', ['id_User' => session('account')['id']]))->with('error_alert', 'Anda hanya boleh menambahkan data anda sendiri!.');
    }

    public function create(Request $request)
    {
        $validation = $this->validation();
        $validated = $request->validate($validation[0],$validation[1],$validation[2]);

        try {
            $cek_hp = Emergency_contact::where('telepon', $request['telepon'])
                ->where('users_id', $request['users_id'])
                ->first();
            $cek_email = Emergency_contact::where('email', $request['email'])
                ->where('users_id', $request['users_id'])
                ->first();

            if ($cek_hp == null && $cek_email == null) {
                DB::beginTransaction();

                $validated['users_id'] = $request['users_id'];
                $emergency_contact_save = Emergency_contact::create($validated);
                $this->MakeLog('User Berhasil Mengakses Menambahkan Data '.$this->aksi, ['data' => $emergency_contact_save]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil membuat Kontak Darurat',
                    'error' => $emergency_contact_save,
                ], 200);
            } else {
                $message = [];

                if ($cek_hp != null) {
                    $message[] = 'Nomor Telepon: '.$request['telepon'];
                }

                if ($cek_email != null) {
                    $message[] = 'Email: '.$request['email'];
                }

                $finalMessage = implode("\n", $message);

                return response()->json([
                    'success' => false,
                    'error' => 'Data Emergency ini sudah terdaftar atau terpakai. Berikut detailnya: '.$finalMessage,
                ], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Kontak Darurat',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function validation($id=null)
    {
        $table = 'emergency_contacts';
        if($id == null){
            $id='';
        }else{
            $id=','.$id;
        }
        return
            [
                [
                'nama_lengkap' => [
                    'required',
                    'string',
                    'max:200',
                    "regex:/^(?=.*[A-Za-z])[A-Za-z' ]+$/",
                ],
                'status_hubungan' => 'required|string|max:100',
                'telepon' => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/^(?![ +-])(?!.*\+\+)(?!.*--)(?=.*\d)[0-9+\- ]+$/',
                    'unique:'.$table.',telepon'.$id
                ],
                'email' => 'required|email|max:100|unique:'.$table.',email'.$id,
                'alamat' => 'required|string|max:300',
            ],
            [
                'required' => ':attribute Kontak Darurat wajib diisi.',
                'max' => ':attribute Kontak Darurat maksimal :max karakter.',
                'string' => ':attribute Kontak Darurat harus berupa text.',
                'email.email' => 'Format Email Kontak Darurat tidak valid.',
                'unique' => ':attribute Sudah Terdaftar Pada Data Kontak Darurat!.',
                'nama_lengkap.regex' => 'Nama Lengkap Kontak Darurat hanya boleh berisi huruf, spasi, dan tanda petik (\') serta harus mengandung minimal 1 huruf.',
                'telepon.regex' => 'Telepon Kontak Darurat hanya boleh berisi angka, spasi, tanda + dan -, tidak boleh diawali spasi atau -, dan harus mengandung angka.',
            ],[
                'nama_lengkap' => 'Nama Lengkap',
                'status_hubungan' => 'Status Hubungan',
                'telepon' => 'Nomor Telepon',
                'email' => 'Email',
                'alamat' => 'Alamat'
            ]
            ];
    }

    public function updateView($id_User, $id_emergency_contact)
    {
        $cek_user = User::where('id', $id_User)->first();

        if ($this->onlyOwnerAdminAndSdm($id_User) == true) {
            if (! $cek_user) {
                return $this->handleRedirectBack()->with('error_alert', 'User tidak ditemukan!.');
            }

            $ec = Emergency_contact::where('id', $id_emergency_contact)->first();

            if (! $ec) {
                return $this->handleRedirectBack()->with('error_alert', 'Data Emergency Tidak Ditemukan!.');
            }
            $user = (new ProfileController)->based_user_data($id_User);

            $this->MakeLog('User Berhasil Mengakses Halaman Perbarui Data '.$this->aksi, ['data' => $ec]);

            return view('kelola_data.emergency_contact.update', ['data' => $ec, 'user' => $user]);
        }

        return redirect(route('profile.emergency-contacts.list', ['id_User' => session('account')['id']]))
            ->with('error_alert', 'Anda hanya boleh mengelola data anda sendiri!.');

    }

    public function updateData(Request $request, $id_User, $id_emergency_contact)
    {
        $user = User::where('id', $id_User)->first();
        if (! $user) {
            return $this->handleRedirectBack()->with('error_alert', 'User Tidak Ditemukan!.');
            }
            if ($this->onlyOwnerAdminAndSdm($id_User) == true) {
                $ec = Emergency_contact::where('id', $id_emergency_contact)->first();
                if(!$ec){
                return $this->handleRedirectBack()->with('error_alert', 'Data Kontak Darurat Tidak Ditemukan!.');
            }
                $validastion = $this->validation($id_emergency_contact);
                $validated = $request->validate($validastion[0],$validastion[1],$validastion[2]);

            $old = $ec;

            DB::beginTransaction();

            try {
                // if (! $ec) {
                //     throw new \Exception('Data Emergency Contact tidak ditemukan.');
                // }

                $new = $ec->update($validated);

                DB::commit();

                // Bagian Cache Forget telah dihapus
                $this->MakeLog('User Berhasil Memperbarui Data '.$this->aksi, ['old' => $old, 'new' => $new]);
                $route = null;
                if (session('account')['is_admin'] && $id_User != session('account')['id']) {
                    $route = redirect(route('manage.emergency-contact.list', ['id_User' => $id_User]))
                        ->with('success', 'Kontak darurat berhasil diperbarui.');
                } else {
                    $route = redirect(route('profile.emergency-contacts.list', ['id_User' => session('account')['id']]))
                        ->with('success', 'Kontak darurat berhasil diperbarui.');
                }

                return $this->CekReview($route, '1E2', 'MENGUBAH DATA EMERGENCY KONTAK');

            } catch (\Exception $e) {
                DB::rollBack();
                $this->MakeLog('User Gagal Memperbarui Data '.$this->aksi, ['alasan' => $e->getMessage()]);

                return $this->handleRedirectBack()
                    ->with('message', 'Terjadi kesalahan: '.$e->getMessage());
            }
        }

        return redirect(route('profile.emergency-contacts.list', ['id_User' => session('account')['id']]))->with('error_alert', 'Anda hanya boleh mengelola data anda sendiri!.');
    }


}
