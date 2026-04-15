<?php

namespace Database\Seeders;

use App\Models\DosenHasKK;
use App\Models\Emergency_contact;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Pengawakan;
use App\Models\ref_work_position;
use App\Models\RefJenjangPendidikan;
use App\Models\RefSubKelompokKeahlian;
use App\Models\RiwayatJenjangPendidikan;
use App\Models\RiwayatNip;
use App\Models\SK;
use App\Models\Tpa;
use App\Models\User;
use App\Models\work_position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ALUR:
        // PEGAWAI TIPENYA APA? SELAIN TETAP&CAPEG => AMANDEMEN


        // Create admin user
        // $user1 = User::factory()->admin()->create([
        //     'nama_lengkap' => 'Admin Telkom University',
        //     'email_institusi' => 'admin@telkomuniversity.ac.id',
        // ]);



        // // Create test user accounts
        // $user2 = User::factory()->create([
        //     'nama_lengkap' => 'Budi Santoso',
        //     'email_institusi' => 'budi.santoso@telkomuniversity.ac.id',
        // ]);

        // $user3 = User::factory()->create([
        //     'nama_lengkap' => 'Siti Nurhaliza',
        //     'email_institusi' => 'siti.nurhaliza@telkomuniversity.ac.id',
        // ]);

        // User::create([
        //     'nama_lengkap' => 'Siti Nurhaliza',
        //     'telepon' => '087895732155',
        //     'email_institusi' => 'siti.nurhaliza@telkomuniversity.ac.id',
        //     'password' => 'password123',
        // ]);

        // User::create([
        //     'nama_lengkap' => 'Budi Santoso',
        //     'telepon' => '084553776814',
        //     'email_institusi' => 'budi.santoso@telkomuniversity.ac.id',
        //     'password' => 'password123',
        // ]);

        User::factory()->create([
            'id' => '342q-234t-234x-432i',
            'nama_lengkap' => 'Admin Telkom University',
            'email_institusi' => 'admin@telkomuniversity.ac.id',
            'is_admin' => 1,
            'is_new' => 0,
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'id' => '342q-234t-234x-4325',
            'nama_lengkap' => 'Dosen Telkom University',
            'email_institusi' => 'dosen@telkomuniversity.ac.id',
            'is_admin' => 0,
            'is_new' => 0,
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'id' => '342q-234t-234x-4o25',
            'nama_lengkap' => 'TPA Telkom University',
            'email_institusi' => 'tpa@telkomuniversity.ac.id',
            'is_admin' => 0,
            'is_new' => 0,
            'email_verified_at' => now(),
        ]);

        $needs = DB::table('formations as a')
            ->sum('a.kuota');
        // dd();
        User::factory()->count(((int) $needs) - 1)->create([
            'is_admin' => 0,
        ]);
        // User::factory();

        $refJenjangPendidikan = \App\Models\RefJenjangPendidikan::all();
        $refPangkatGolongan = \App\Models\RefPangkatGolongan::all();
        $refStatusPegawai = \App\Models\RefStatusPegawai::all();
        $refJFA = \App\Models\RefJabatanFungsionalAkademik::all();
        $refJFK = \App\Models\RefJabatanFungsionalKeahlian::all();

        $refFormasi = \App\Models\Formation::all();
        $refProdi = work_position::where('type_work_position', 'Program Studi')->get();
        $refbagian = ref_work_position::all();

        // dd($refbagian);
        // dd(count($refProdi));
        // dd($refProdi[0]);



        //sort by created at agar yg pertama adalah admin
        $users = User::all()->sortBy('created_at');


        foreach ($users as $user) {
            // Buat history NIP
            $indexRefStatusPegawai = fake()->numberBetween(0, count($refStatusPegawai) - 1);
            $penentuanSKorAmandemen = ($refStatusPegawai[$indexRefStatusPegawai]['status_pegawai'] == 'PEGAWAI TETAP' || $refStatusPegawai[$indexRefStatusPegawai]['status_pegawai'] == 'CALON PEGAWAI TETAP');

            $skYptOrAmandemen = null;
            if ($penentuanSKorAmandemen == true) {
                $skYptOrAmandemen = SK::factory()->ypt()->create([
                    'keterangan' => 'Penetapan dan/atau perubahan status, jabatan, serta hak kepegawaian pegawai berdasarkan hasil evaluasi, kebutuhan organisasi, dan kebijakan yang berlaku.',
                ]);
            } else {
                $skYptOrAmandemen = SK::factory()->AMANDEMEN()->create([
                    'keterangan' => 'Penetapan, perpanjangan, atau perubahan kontrak kerja pegawai berdasarkan kesepakatan para pihak, hasil evaluasi kinerja, dan ketentuan yang berlaku.',
                ]);
            }

            RiwayatNip::factory()->create([
                'users_id' => $user->id,
                'nip' => fake()->unique()->numerify('##############'),
                'status_pegawai_id' => $refStatusPegawai[$indexRefStatusPegawai]['id'],
                'sk_ypt_or_amandemen' => $skYptOrAmandemen['id'],
                // 'status_pegawai_id' => (string) data_get($refStatusPegawai[$indexRefStatusPegawai], 'id'),

            ]);

            $user->sk_obj = $skYptOrAmandemen;
        }

        // dd($users[0]->sk_obj);



        $countUser = 0;


        $formasi1 = DB::select("
            SELECT 
                a.id id_formasi, 
                a.nama_formasi,
                a.kuota, 
                b.id work_position_id,
                b.type_pekerja tipe_pegawai 
            FROM formations a 
            JOIN work_positions b ON b.id = a.work_position_id
            JOIN levels c ON c.id = a.level_id
            ORDER BY c.urut ASC
        ");

        $formasiAnggota = DB::select("
        SELECT 
                a.id id_formasi, 
                a.nama_formasi,
                a.kuota, 
                b.id work_position_id, 
                b.type_pekerja tipe_pegawai 
            FROM formations a 
            JOIN work_positions b ON b.id = a.work_position_id
            JOIN levels c ON c.id = a.level_id
            WHERE c.urut=5
            ORDER BY c.urut ASC
        
        ");
        // dd($formasi1[0]);
        $count_user = 0;
        foreach ($formasi1 as $formasi) {
            // dd($formasi);
            for ($i = 1; $i <= (int) $formasi->kuota; $i++) {
                $this->petakan($formasi, $users[$count_user], true);
                $count_user++;
            }
        }

        $random_index = range(0, 38);
        shuffle($random_index);
        $index_random = 0;

        foreach ($formasiAnggota as $formasi) {
            // dd($formasi, $formasi->kuota);
            for ($i = 1; $i <= $formasi->kuota; $i++) {
                $this->petakan($formasi, $users[$random_index[$index_random]], false);
                $index_random++;
            }
        }
    }

    public function basic_data($user_data, $tipe_pegawai, $formasi)
    {
        $user = User::where('id', $user_data->id)->first();
        $user->tipe_pegawai = $tipe_pegawai;
        $user->save();

        $refJenjangPendidikan = \App\Models\RefJenjangPendidikan::all();
        $refPangkatGolongan = \App\Models\RefPangkatGolongan::all();
        $refStatusPegawai = \App\Models\RefStatusPegawai::all();
        $refJFA = \App\Models\RefJabatanFungsionalAkademik::all();
        $refJFK = \App\Models\RefJabatanFungsionalKeahlian::all();
        $SubkelompokKeahlian = \App\Models\RefSubKelompokKeahlian::all();


        emergency_contact::factory(2)->create([
            'users_id' => $user->id,
        ]);







        //pendidikan
        $pendidikan1 = null;
        $pendidikan2 = null;
        $pendidikan3 = null;
        $pendidikan4 = null;
        if (fake()->boolean()) {
            //pendidikan1 must be s1/d3
            $pendidikan1 = RiwayatJenjangPendidikan::factory()->create([
                'users_id' => $user->id,
                'jenjang_pendidikan_id' => RefJenjangPendidikan::where(
                    'jenjang_pendidikan',
                    fake()->randomElement(['S1', 'D3'])
                )->first()->id,
            ]);

            if ($pendidikan1 != null && fake()->boolean()) {
                $pendidikan2 = RiwayatJenjangPendidikan::factory()->create([
                    'users_id' => $user->id,
                    'jenjang_pendidikan_id' => RefJenjangPendidikan::where('urutan', (int) RefJenjangPendidikan::where('id', $pendidikan1->jenjang_pendidikan_id)->first()['urutan'])->first()->id,
                ]);
            }

            if ($pendidikan2 != null && fake()->boolean()) {
                $pendidikan3 = RiwayatJenjangPendidikan::factory()->create([
                    'users_id' => $user->id,
                    'jenjang_pendidikan_id' => RefJenjangPendidikan::where('urutan', (int) RefJenjangPendidikan::where('id', $pendidikan2->jenjang_pendidikan_id)->first()['urutan'])->first()->id,
                ]);
            }

            if ($pendidikan3 != null && fake()->boolean()) {
                $pendidikan4 = RiwayatJenjangPendidikan::factory()->create([
                    'users_id' => $user->id,
                    'jenjang_pendidikan_id' => RefJenjangPendidikan::where('urutan', (int) RefJenjangPendidikan::where('id', $pendidikan3->jenjang_pendidikan_id)->first()['urutan'])->first()->id,
                ]);
            }
        }

        $create_dosen_or_tpa = null;
        if ($user->tipe_pegawai === 'Dosen') {
            $indexRefPangkatGolongan = fake()->numberBetween(0, count($refPangkatGolongan) - 1);
            $indexRefJFA = fake()->numberBetween(0, count($refJFA) - 1);
            // $indexProdi =  null;
            // dd($refProdi[$indexProdi]->id);
            $dosen = \App\Models\Dosen::factory()->create([
                'users_id' => $user->id,
                'prodi_id' => $formasi->work_position_id,
            ]);

            // Assign kelompok keahlian ke dosen
            $randomNumber = fake()->numberBetween(0, count($SubkelompokKeahlian) - 1);
            // if ($kelompokKeahlian->isNotEmpty()) {
            //     $numAssign = fake()->numberBetween(1, min(3, $kelompokKeahlian->count()));
            //     $assignedKK = $kelompokKeahlian->random($numAssign);
            //     foreach ($assignedKK as $kk) {
            //         $dosen->kelompokKeahlian()->attach($kk->id);
            //     }
            // }

            $kk_dosen = DosenHasKK::factory()->create([
                'dosen_id' => $dosen->id,
                'sub_kk_id' => $SubkelompokKeahlian[$randomNumber]->id,
            ]);


            $skLLKDIKTI = null;
            // $skYPT = null;
            // dd($user_data->sk_obj['tipe_dokumen']);
            if ($user_data->sk_obj->tipe_dokumen == 'SK') {
                $skLLKDIKTI = SK::factory()->lldikti()->create([
                    // 'users_id' => $user->id,
                    'tipe_sk' => 'LLDIKTI',
                    'keterangan' => 'Penetapan dan/atau perubahan status, jabatan, serta hak kepegawaian pegawai berdasarkan hasil evaluasi, kebutuhan organisasi, dan kebijakan yang berlaku.',
                ]);
            } else {
                $skLLKDIKTI = $user_data->sk_obj;
            }
            $skYPT = $user_data->sk_obj;


            // dd($refPangkatGolongan[$indexRefPangkatGolongan]->id);
            \App\Models\RiwayatPangkatGolongan::factory()->create([
                'dosen_id' => $dosen->id,
                'pangkat_golongan_id' => $refPangkatGolongan[$indexRefPangkatGolongan]->id,
                'sk_llkdikti_id' => $skLLKDIKTI->id,
                // 'sk_pengakuan_ypt_id' => $skYPT->id,
            ]);

            \App\Models\RiwayatJabatanFungsionalAkademik::factory()->create([
                'dosen_id' => $dosen->id,
                'ref_jfa_id' => $refJFA[$indexRefJFA]->id,
                'sk_llkdikti_id' => $skLLKDIKTI->id,
                'sk_pengakuan_ypt_id' => $skYPT->id,
                'tmt_mulai' => now(),
            ]);
        } else {
            $skLLKDIKTI = SK::factory()->ypt()->create([
                // 'users_id' => $user->id,
                'keterangan' => 'Penetapan dan/atau perubahan status, jabatan, serta hak kepegawaian pegawai berdasarkan hasil evaluasi, kebutuhan organisasi, dan kebijakan yang berlaku.',

            ]);
            $tpa_models = Tpa::factory()->create([
                'users_id' => $user->id,
                'nitk' => fake()->unique()->numerify('#############'),
            ]);
            // dd($tpa_models);

            $indexRefJFK = fake()->numberBetween(0, count($refJFK) - 1);
            // dD($indexRefJFK);
            $boolRandom = fake()->boolean();
            $sk = $boolRandom == true ? $skLLKDIKTI->id : null;
            \App\Models\RiwayatJabatanFungsionalKeahlian::factory()->create([
                'tpa_id' => $tpa_models->id,
                'ref_jfk_id' => $refJFK[$indexRefJFK]->id,
                // 'sk_llkdikti_id' => $skLLKDIKTI->id,
                'sk_pengakuan_ypt_id' => $sk,
                'tmt_mulai' => now(),
                'tmt_selesai' => null,
            ]);
        }
    }

    public function petakan($formasi, $user_data, $is_first)
    {

        // dd($formasi);


        $skYPT = $user_data->sk_obj;

        $is_main = false;
        $tipe_pegawai = null;
        if ($is_first == true) {
            $normalize_tipe_pegawai = null;
            if ($user_data->email_institusi == 'tpa@telkomuniversity.ac.id') {
                $normalize_tipe_pegawai = 'Tpa';
            } else if ($user_data->email_institusi == 'dosen@telkomuniversity.ac.id') {
                $normalize_tipe_pegawai = 'Dosen';
            } else {
                $normalize_tipe_pegawai = $formasi->tipe_pegawai == 'Both'
                    ? fake()->randomElement(['Tpa', 'Dosen'])
                    : $formasi->tipe_pegawai;
            }
            $tipe_pegawai = $normalize_tipe_pegawai;
            $is_main = true;
        }


        // $is_today = fake()->boolean();
        
        $tmt_finish = now()->addDays(fake()->randomElement([1, 10]));
        if(fake()->boolean()){
            $tmt_finish = fake()->date();
        }
        $pemetaan = Pengawakan::factory()->create([
            'users_id' => $user_data->id,
            'formasi_id' => $formasi->id_formasi,
            'sk_ypt_id' => $skYPT->id,
            'tmt_selesai' => $tmt_finish,
            'is_main_position' => $is_main
        ]);
        // $tipe_pegawai = $is_first == true ? $normalize_tipe_pegawai : null;
        if ($is_first == true) {
            $this->basic_data($user_data, $tipe_pegawai, $formasi);
        }
    }

    // public function cek_if_same_position($formasi_position, $user_id)
    public function cek_if_same_position($formasi_position, $user_id, $users, $count, $random_index, $penambahan = 0)
    {
        if ($penambahan == 0) {
            $penambahan = 0;
        }
        if ($user_id == null) {
            $user_id = $users[$random_index[$count + $penambahan]];
        }
        $cek = DB::select("
            SELECT c.id as position from formations a 
            join pengawakans b on b.formasi_id=a.id
            join work_positions c on c.id=a.work_position_id

            where b.users_id = '" . $user_id . "'
        ");
        // dd($cek);
        if ($cek[0]->position == $formasi_position) {
            $penambahan++;
            $this->cek_if_same_position($formasi_position, null, $users, $count, $random_index, $penambahan);
        } else {
            return $penambahan;
        }
    }
}
