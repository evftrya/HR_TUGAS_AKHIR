<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmergencyContactAddDataEmergencyContactSubmitFormTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseTransactions;

    public function test_EMERGENCYCONTACT_AKSES_HALAMAN_UBAH_DATA(): void
    {
        $this->assertTrue(true);
    }
    /**
     * A basic feature test example.
     */

    public function test_R2e1UserNotLoginTryToSubmit(){
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => 'asjhdak',
            ]),
            [
                'jzdhfhjk' => 'aksjd'
            ]
        );

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
    public function test_R2e2UserWhichRoleNotInAdminOrSdmTryToAddNewEcToAnotherEmployee(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,false);
        $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonrole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => $user_admin['id'],
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '089564512312',
                'email' => 'ekhgf@dkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $this->userOutAkses($response);
    }

    public function test_R2e3AdminAddEmployeeEcDataButWrongIdEmployee(): void
    {
        $admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => '0321313',
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '089564512312',
                'email' => 'ekhgf@dkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $this->userNotFound($response);
    }


    public function test_R2e4AdminAddHersEcDataButWrongIdEmployee(): void
    {
        $admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        // $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => '0321313',
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '089564512312',
                'email' => 'ekhgf@dkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $this->userNotFound($response);
    }

    public function test_R2e5SdmAddEmployeeEcDataButWrongIdEmployee(): void
    {
        $sdm = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => '0321313',
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '089564512312',
                'email' => 'ekhgf@dkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $this->userNotFound($response);
    }

    public function test_R2e6ValidRoleAddEcDataButWrongFormat(): void
    {
        $sdm = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => $user_admin['id'],
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529100',
                'email' => 'zsdzsdz@djfkgdfg',
                'alamat' => 'onetwotree',
            ]
        );
        // dd($response);
        // $response->assertStatus(422);
        $this->failed($response);
        // 'Nomor Emergency dengan Pegawai Ini Sudah Terdaftar, Coba yang Lain!.'
    }

    public function test_R2e7SdmAddEnotherEcDatabutNumberAlreadyRegistered(): void
    {
        $sdm = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529101']);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => $user_admin['id'],
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529101',
                'email' => 'zsdzsdz@djfkgdfg',
                'alamat' => 'onetwotree',
            ]
        );
        // dd($response);
        // $response->assertStatus(422);
        $this->failed($response);
    }

    public function test_R2e8SdmAddEnotherEcDatabutNumberAlreadyRegistered(): void
    {
        $sdm = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529101']);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => $user_admin['id'],
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529102',
                'email' => 'zsdzsdz@djfkgdfg',
                'alamat' => 'onetwotree',
            ]
        );
        // dd($response);
        // $response->assertStatus(422);
        $this->success($response);
    }

    public function test_R2e9PegawaiAddOwnEcData(): void
    {
        $pegawai = $this->define_account(false,false, true, 'admin@yyy',true,false);
        // $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $pegawai['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => $pegawai['id'],
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529100',
                'email' => 'zsdzsdz@djfkgdfg',
                'alamat' => 'onetwotree',
            ]
        );
        // dd($response);
        // $response->assertStatus(422);
        $this->success($response);
        // 'Nomor Emergency dengan Pegawai Ini Sudah Terdaftar, Coba yang Lain!.'
    }


    public function test_R2e10SdmAddOwnEcData(): void
    {
        $sdm = $this->define_account(false,false, true, 'admin@yyy',true,false);
        // $user_admin = $this->define_account(false,false, true, 'other@yyy',true,true);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.new-data', [
                'id_User' => $sdm['id'],
            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529100',
                'email' => 'zsdzsdz@djfkgdfg',
                'alamat' => 'onetwotree',
            ]
        );
        // dd($response);
        // $response->assertStatus(422);
        $this->success($response);
        // 'Nomor Emergency dengan Pegawai Ini Sudah Terdaftar, Coba yang Lain!.'
    }





    public function success($response){
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Emergency contact berhasil dibuat.');
    }

    public function failed($response){
        $response->assertRedirect();
        $response->assertSessionHas('message');
        $message = session('message');
        $this->assertStringContainsString('Emergency contact Gagal Dibuat', $message);
    }



    public function userNotFound($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'User tidak ditemukan!.');
    }

    public function userOutAkses($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'Anda hanya boleh menambahkan data anda sendiri!.');
    }

    public function userFound($response)
    {
        $response->assertStatus(200);
        $response->assertViewIs('kelola_data.emergency_contact.update');
    }

    public function NumberNotFound($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert',
        'Data Emergency Tidak Ditemukan!.');
    }
}
