<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmergencyContactUbahDataEmergencyContactSubmitFormTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_EMERGENCYCONTACT_SubmitForm_UBAH_DATA(): void
    {
        $this->assertTrue(true);
    }
    /**
     * A basic feature test example.
     */

    public function test_R2b1UserNotLoginTryToSubmit(){
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => 'asjhdak',
                'id_emergency_contact' => 'isdkfskjd'
            ]),
            [
                'jzdhfhjk' => 'aksjd'
            ]
        );

        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
    public function test_R2b2UserWhichRoleNotInAdminOrSdmTryToUpdateEcAnotherEmployee(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,false);
        $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonrole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => 'gjhk',
                'id_emergency_contact' => 'isdkfskjd'

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

    public function test_R2b3UserWithValidRoleSubmitButWrongFormat(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['telepon', 'email']);
        $response->assertJson([
            'errors' => [
                'telepon' => [
                    'telepon Kontak Darurat maksimal 15 karakter.'
                ],
                'email' => [
                    'Format Email Kontak Darurat tidak valid.'
                ]
            ]
        ]);
    }

    public function test_R2b4PegawaiSubmitButWrongFormat(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        // $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonrole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['telepon', 'email']);
        $response->assertJson([
            'errors' => [
                'telepon' => [
                    'telepon Kontak Darurat maksimal 15 karakter.'
                ],
                'email' => [
                    'Format Email Kontak Darurat tidak valid.'
                ]
            ]
        ]);
    }

    public function test_R2b5PegawaiDenganRoleSdmSubmitButWrongFormat(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        // $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonrole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['telepon', 'email']);
        $response->assertJson([
            'errors' => [
                'telepon' => [
                    'telepon Kontak Darurat maksimal 15 karakter.'
                ],
                'email' => [
                    'Format Email Kontak Darurat tidak valid.'
                ]
            ]
        ]);
    }

    public function test_R2b6AdminSubmitUpdateAnotherEcDataButWrongFormat(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['telepon', 'email']);
        $response->assertJson([
            'errors' => [
                'telepon' => [
                    'telepon Kontak Darurat maksimal 15 karakter.'
                ],
                'email' => [
                    'Format Email Kontak Darurat tidak valid.'
                ]
            ]
        ]);
    }

    public function test_R2b7AdminWithRoleSdmSubmitUpdateAnotherEcDataButWrongFormat(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['telepon', 'email']);
        $response->assertJson([
            'errors' => [
                'telepon' => [
                    'telepon Kontak Darurat maksimal 15 karakter.'
                ],
                'email' => [
                    'Format Email Kontak Darurat tidak valid.'
                ]
            ]
        ]);
    }

    public function test_R2b8AdminWithRoleSdmSubmitUpdateAnotherEcDataButWrongIdEmployee(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => 'ghjk',
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $this->userNotFound($response);
    }
    public function test_R2b9AdminSubmitUpdateAnotherEcDataButWrongIdEmployee(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->postJson(
            route('profile.emergency-contacts.updateData', [
                'id_User' => 'ghjk',
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => 'aaaaaaaaaaaaaaaa',
                'email' => 'ekhgfdkfgd',
                'alamat' => 'onetwotree',
            ]
        );
        $this->userNotFound($response);
    }

    public function test_R2b10ValidRoleUpdateButNumberAlreadyRegitered(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529110']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->post(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529100',
                'email' => 'asf@esdfd',
                'alamat' => 'onetwotree',
            ]
        );
        // dd(request()->session()->has('account'));
        // DD($response);
        $this->failed($response);
    }


    public function test_R2b11ValidRoleUpdateTheirEcDataSuccess(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        // $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529110']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonrole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->post(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529101',
                'email' => 'asf@esdfd',
                'alamat' => 'onetwotree',
            ]
        );
        // dd(request()->session()->has('account'));
        // DD($response);
        $this->success($response);
    }
    public function test_R2b12AdminWithSdmRoleUpdateTheirEcEmployeeSuccess(): void
    {
        // $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $sdm = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $sdm['id'], 'telepon' => '08972529100']);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529110']);

        $login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->post(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $sdm['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529101',
                'email' => 'asf@esdfd',
                'alamat' => 'onetwotree',
            ]
        );
        // dd(request()->session()->has('account'));
        // DD($response);
        $this->success($response);
    }

    public function test_R2b13SdmUpdateAnotherEcEmployeeSuccess(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $sdm = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529110']);

        $login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->post(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529101',
                'email' => 'asf@esdfd',
                'alamat' => 'onetwotree',
            ]
        );
        // dd(request()->session()->has('account'));
        // DD($response);
        $this->success($response);
    }

    public function test_R2b14AdminWithRoleSdmUpdateAnotherEcEmployeeSuccess(): void
    {
        $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $sdm = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $nonrole['id'], 'telepon' => '08972529100']);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529110']);

        $login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->post(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $nonrole['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529101',
                'email' => 'asf@esdfd',
                'alamat' => 'onetwotree',
            ]
        );
        // dd(request()->session()->has('account'));
        // DD($response);
        $this->success($response);
    }

    public function test_R2b15SdmUpdateTheirEcEmployeeSuccess(): void
    {
        // $nonrole = $this->define_account(false,false, true, 'nonrole@yyy',true,true);
        $sdm = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $sdm['id'], 'telepon' => '08972529100']);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529110']);

        $login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->post(
            route('profile.emergency-contacts.updateData', [
                'id_User' => $sdm['id'],
                'id_emergency_contact' => $make_ec['id']

            ]),
            [
                'nama_lengkap' => 'jija',
                'status_hubungan' => 'Adik Kandung',
                'telepon' => '08972529101',
                'email' => 'asf@esdfd',
                'alamat' => 'onetwotree',
            ]
        );
        // dd(request()->session()->has('account'));
        // DD($response);
        $this->success($response);
    }







    public function success($response){
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Kontak darurat berhasil diperbarui.');
    }

    public function failed($response){
        $response->assertRedirect();
        // dd(session('message'));
        $response->assertSessionHas('message');
        $message = $response->getSession()->get('message');
        $this->assertStringContainsString('Terjadi kesalahan: ', $message);
    }



    public function userNotFound($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'User Tidak Ditemukan!.');
    }

    public function userOutAkses($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'Anda hanya boleh mengelola data anda sendiri!.');
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
