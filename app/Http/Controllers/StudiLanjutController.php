<?php

namespace App\Http\Controllers;

use App\Models\StudiLanjut;
use App\Models\User;
use Illuminate\Http\Request;

class StudiLanjutController extends Controller
{
    public function index()
    {

        $studiLannjut = null;
        if($this->isAdminOrSdm()==true){
            $studiLanjut = StudiLanjut::with('user')
                ->get()
                ->sortBy(fn ($item) => $item->user->nama_lengkap);
        }else{
            $studiLanjut = StudiLanjut::with('user')->where('users_id', session('account')['id'])
                ->get()
                ->sortBy(fn ($item) => $item->user->nama_lengkap);
        }

        return view('kelola_data.studi_lanjut.list', compact('studiLanjut'));
    }

    public function create()
    {
        $pegawai = '';
        if($this->isAdminOrSdm()==true){
            $pegawai = User::where('is_active', 1)
                ->get()
                ->sortBy('nama_lengkap');
        }else{
            $pegawai = User::where('id', session('account')['id'])->where('is_active', 1)
                ->get()
                ->sortBy('nama_lengkap');
        }

        $route = view('kelola_data.studi_lanjut.input', compact('pegawai'));
            return $this->CekReview($route, '1U3', 'MELIHAT DATA STUDI LANJUT');

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required|uuid|exists:users,id',
            'jenjang' => 'required|in:S2,S3',
            'program_studi' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'negara' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'status' => 'required|in:Dalam Perencanaan,Sedang Berjalan,Selesai,Cuti',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        StudiLanjut::create($validated);

        $route = redirect()->route('manage.studi-lanjut.list')->with('success', 'Data studi lanjut berhasil ditambahkan');
            return $this->CekReview($route, '1U1', 'MENAMBAH DATA STUDI LANJUT');

    }

    public function show($id)
    {
        try {
            $studiLanjut = null;
            try {
                $studiLanjut = StudiLanjut::with('user')->findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Studi Lanjut ini tidak terdaftar!.');
            }

            return view('kelola_data.studi_lanjut.view', compact('studiLanjut'));
        } catch (\Exception $e) {
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {

            $studiLanjut = null;
            try {
                $studiLanjut = StudiLanjut::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Studi Lanjut ini tidak terdaftar!.');
            }
            // dd($this->onlyOwnerAdminAndSdm($studiLanjut->users_id)==true);
            if($this->onlyOwnerAdminAndSdm($studiLanjut->users_id)==false){
                throw new \Exception('Berdasarkan Hak Akses yang anda miliki sekarang, Anda Tidak Diperkenankan mengelola data Studi Lanjut yang bukan milik anda!.');
            }


            $pegawai = '';
            if($this->isAdminOrSdm()==true){
                $pegawai = User::where('is_active', 1)
                    ->get()
                    ->sortBy('nama_lengkap');
            }else{
                $pegawai = User::where('id', session('account')['id'])->where('is_active', 1)
                    ->get()
                    ->sortBy('nama_lengkap');
            }
            // $pegawai = User::where('is_active', 1)
            //     ->get()
            //     ->sortBy('nama_lengkap');

            $route = view('kelola_data.studi_lanjut.edit', compact('studiLanjut', 'pegawai'));
            return $this->CekReview($route, '1U3', 'MELIHAT DATA STUDI LANJUT');

        } catch (\Exception $e) {
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $studiLanjut = null;
            try {
                $studiLanjut = StudiLanjut::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Studi Lanjut ini tidak terdaftar!.');
            }

            if($this->onlyOwnerAdminAndSdm($studiLanjut->users_id)==false){
                throw new \Exception('Berdasarkan Hak Akses yang anda miliki sekarang, Anda Tidak Diperkenankan mengelola data Studi Lanjut yang bukan milik anda!.');
            }

            $validated = $request->validate([
                'users_id' => 'required|uuid|exists:users,id',
                'jenjang' => 'required|in:S2,S3',
                'program_studi' => 'required|string|max:255',
                'universitas' => 'required|string|max:255',
                'negara' => 'required|string|max:100',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
                'status' => 'required|in:Sedang Berjalan,Selesai,Cuti,Dalam Perencanaan',
                'sumber_dana' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string',
            ]);

            $studiLanjut->update($validated);

            $route = redirect()->route('manage.studi-lanjut.list')->with('success', 'Data studi lanjut berhasil diperbarui');
            return $this->CekReview($route, '1U2', 'MENGUBAH DATA STUDI LANJUT');

        } catch (\Exception $e) {
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $studiLanjut = null;
            try {
                $studiLanjut = StudiLanjut::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new \Exception('Studi Lanjut ini tidak terdaftar!.');
            }
            $studiLanjut->delete();

            return redirect()->route('manage.studi-lanjut.list')->with('success', 'Data studi lanjut berhasil dihapus');
        } catch (\Exception $e) {
            return $this->handleRedirectBack()->with('error_alert', $e->getMessage());
        }
    }
}
