<?php

namespace Database\Seeders;

use App\Models\emergency_contact;
use App\Models\pengawakan;
use App\Models\riwayatJenjangPendidikan;
use App\Models\RiwayatNip;
use App\Models\SK;
use App\Models\Tpa;
use App\Models\User;
use App\Models\work_position;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


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

        User::factory()->count(30)->create();

        $refJenjangPendidikan = \App\Models\RefJenjangPendidikan::all();
        $refPangkatGolongan = \App\Models\RefPangkatGolongan::all();
        $refStatusPegawai = \App\Models\RefStatusPegawai::all();
        $refJFA = \App\models\refJabatanFungsionalAkademik::all();
        $refJFK = \App\models\refJabatanFungsionalKeahlian::all();
        $refFormasi = \App\models\formation::all();

        $refProdi = work_position::where('type_work_position', 'Program Studi')->get();

        // dd(count($refProdi));   
        // dd($refProdi[0]);
        

        $users = User::all();
        // dd($users);
        foreach ($users as $user) {
            // dd($user->id);


            $indexRefStatusPegawai = fake()->numberBetween(0, count($refStatusPegawai)-1);
            // dd($refStatusPegawai[$indexRefStatusPegawai]);

            //buat 2 emergency contact
            emergency_contact::factory(2)->create([
                'users_id' => $user->id,
            ]);
            

            RiwayatNip::factory()->create([
                'users_id' => $user->id,
                'nip' => fake()->unique()->numerify('##############'),
                'status_pegawai_id' => $refStatusPegawai[$indexRefStatusPegawai]['id'],
                // 'status_pegawai_id' => (string) data_get($refStatusPegawai[$indexRefStatusPegawai], 'id'),

            ]);

            riwayatJenjangPendidikan::factory()->create([
                'users_id' => $user->id,
                'jenjang_pendidikan_id' => $refJenjangPendidikan[fake()->numberBetween(0, count($refJenjangPendidikan)-1)]->id,
            ]);

            if($user->tipe_pegawai === 'Dosen'){
                $indexRefPangkatGolongan = fake()->numberBetween(0, count($refPangkatGolongan)-1);
                $indexRefJFA = fake()->numberBetween(0, count($refJFA)-1);
                $indexProdi =  fake()->numberBetween(0, count($refProdi)-1);
                // dd($refProdi[$indexProdi]->id);
                $dosen = \App\Models\Dosen::factory()->create([
                    'users_id' => $user->id,
                    'prodi_id' => $refProdi[$indexProdi]->id,

                ]);

                $skLLKDIKTI = SK::factory()->create([
                    'users_id' => $user->id,
                    'tipe_sk' => 'LLDIKTI',
                ]);

                $skYPT = SK::factory()->create([
                    'users_id' => $user->id,
                    'tipe_sk' => 'Pengakuan YPT',
                ]);

                // dd($refPangkatGolongan[$indexRefPangkatGolongan]->id);
                \App\Models\riwayatPangkatGolongan::factory()->create([
                    'dosen_id' => $dosen->id,
                    'pangkat_golongan_id' => $refPangkatGolongan[$indexRefPangkatGolongan]->id,
                    'sk_llkdikti_id' => $skLLKDIKTI->id,
                    // 'sk_pengakuan_ypt_id' => $skYPT->id,
                ]);

                \App\Models\riwayatJabatanFungsionalAkademik::factory()->create([
                    'dosen_id' => $dosen->id,
                    'ref_jfa_id' => $refJFA[$indexRefJFA]->id,
                    'sk_llkdikti_id' => $skLLKDIKTI->id,
                    'sk_pengakuan_ypt_id' => $skYPT->id,
                    'tmt_mulai'=>now(),
                ]);

            }
            else{
                $skLLKDIKTI = SK::factory()->create([
                    'users_id' => $user->id,
                    'tipe_sk' => 'LLDIKTI',
                ]);
                $tpa_models = Tpa::factory()->create([
                    'users_id' => $user->id,
                    'nitk' => fake()->unique()->numerify('#############'),
                ]);
                // dd($tpa_models);

                $indexRefJFK = fake()->numberBetween(0, count($refJFK)-1);
                // dD($indexRefJFK);
                \App\Models\riwayatJabatanFungsionalKeahlian::factory()->create([
                    'tpa_id' => $tpa_models->id,
                    'ref_jfk_id' => $refJFK[$indexRefJFK]->id,
                    // 'sk_llkdikti_id' => $skLLKDIKTI->id,
                    'sk_pengakuan_ypt_id' => null,
                    'tmt_mulai'=>now(),
                    'tmt_selesai'=>null,
                ]);
            }

            $skYPT = SK::factory()->create([
                    'users_id' => $user->id,
                    'tipe_sk' => 'Pengakuan YPT',
                ]);

            $indexRefFormasi = fake()->numberBetween(0, count($refFormasi)-1);
            $pemetaan = pengawakan::factory()->create([
                'users_id' => $user->id,
                'formasi_id' => $refFormasi[$indexRefFormasi]->id,
                'sk_ypt_id' => $skYPT->id,
                'tmt_selesai' => null,
            ]);
        }
    }
}
