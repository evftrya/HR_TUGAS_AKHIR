<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RefSubKelompokKeahlianController extends Controller
{

    public function index()
    {
        $results = DB::select("
            SELECT 
                m.id as fakultas_id, m.position_name as fakultas_name, m.kode as fakultas_code,
                a.id as kk_id, a.nama as kk_name, a.kode as kk_code,   a.deskripsi as kk_deskripsi,
                
                b.id as sub_kk_id, b.nama as sub_kk_name, b.kode as sub_kk_desc, b.deskripsi as sub_kk_deskripsi,
                d.id as dosen_id, e.id as users_id, e.nama_lengkap as dosen_name, c.id as dosen_has_kk_id,
                y.position_name as prodi 
            FROM kelompok_keahlian a 
            JOIN work_positions m ON m.id = a.fakultas_id
            LEFT JOIN ref_sub_kelompok_keahlians b ON b.kk_id = a.id
            JOIN dosen_has_kk c ON c.sub_kk_id = b.id
            LEFT JOIN dosens d ON d.id = c.dosen_id
            LEFT JOIN work_positions y ON y.id = d.prodi_id
            LEFT JOIN users e ON e.id = d.users_id

            where c.is_active=1
        ");

        // $dosen = Dosen::with('pegawai_aktif')->get()->sortBy('pegawai_aktif.nama_lengkap');
        // dd($dosen);
        $dosen = Dosen::with('pegawai_aktif')
            ->get()
            ->sortBy(function ($item) {
                // Mengurutkan berdasarkan nama_lengkap, jika null taruh di bawah atau beri string kosong
                return $item->pegawai_aktif->nama_lengkap ?? '';
            });
            // dd($dosen);

        $database = collect($results)->groupBy('fakultas_id')->map(function ($fakultasGroup) {
            $firstFak = $fakultasGroup->first();
            return [
                'id'   => $firstFak->fakultas_id,
                'name' => $firstFak->fakultas_name,
                'code' => $firstFak->fakultas_code,
                'kks'  => $fakultasGroup->groupBy('kk_id')->map(function ($kkGroup) {
                    $firstKk = $kkGroup->first();
                    return [
                        'id'    => $firstKk->kk_id,
                        'name'  => $firstKk->kk_name,
                        'code'  => $firstKk->kk_code,
                        'subs'  => $kkGroup->groupBy('sub_kk_id')->map(function ($subGroup) {
                            $firstSub = $subGroup->first();
                            if (!$firstSub->sub_kk_id) return null;

                            return [
                                'id'     => $firstSub->sub_kk_id,
                                'name'   => $firstSub->sub_kk_name,
                                'code'   => $firstSub->sub_kk_desc,
                                'dosens' => $subGroup->filter(fn($item) => $item->dosen_id != null)
                                    ->map(function ($dosen) {
                                        return [
                                            'id_pemetaan' => $dosen->dosen_has_kk_id,
                                            'nama'  => $dosen->dosen_name,
                                            'prodi' => $dosen->prodi,
                                            'foto'  => "https://i.pravatar.cc/150?u=" . $dosen->users_id
                                        ];
                                    })->values()->toArray()
                            ];
                        })->filter()->values()->toArray()
                    ];
                })->values()->toArray()
            ];
        })->values()->toArray();
        // dd($database);
        return view('kelola_data.kelompok_keahlian.sub.list', compact('database', 'dosen'));

        // return view('nama_file_view', compact('database'));
    }
}
