<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmergencyContactUbahDataEmergencyContactAksesHalamanTest extends TestCase
{
    use DatabaseTransactions;

    public function test_EMERGENCYCONTACT_AKSES_HALAMAN_UBAH_DATA(): void
    {
        $this->assertTrue(true);
    }
    /**
     * A basic feature test example.
     */
    public function test_r2c1UserValidRoleMengakses_Test(): void
    {
        $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => $user_admin['id'],
            'id_emergency_contact' => $make_ec['id']
        ]));

        // dd($response);

        $this->userFound($response);
    }

    public function test_r2c2AdminAksesHalamanUbahDataEcSendiri_Test(): void
    {
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => $user_admin['id'],
            'id_emergency_contact' => $make_ec['id']
        ]));

        // dd($response);

        $this->userFound($response);
    }

    public function test_r2c3SdmStaffAksesHalamanUbahDataEcPegawai_Test(): void
    {
        $sdm = $this->define_account(false,false, true, 'sdm@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => $user_admin['id'],
            'id_emergency_contact' => $make_ec['id']
        ]));

        // dd($response);

        $this->userFound($response);
    }

    public function test_r2c4ValidRoleButIdEcTidakTerdaftar_Test(): void
    {
        $sdm = $this->define_account(false,false, true, 'sdm@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => $user_admin['id'],
            'id_emergency_contact' => 'tfgh'
        ]));
        $this->NumberNotFound($response);
    }


    public function test_r2c6ValidRoleButIdPegawaiTidakTerdaftar_Test(): void
    {
        $sdm = $this->define_account(false,false, true, 'sdm@yyy',true,true);
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => 'zhfdzjkdf',
            'id_emergency_contact' => 'tfgh'
        ]));
        $this->userNotFound($response);
    }

    public function test_r2c7AdminAksesPegawaiHalamanUbahButIdPegawaiTidakTerdaftar_Test(): void
    {
        $admin = $this->define_account(true,false, true, 'sdm@yyy',true,false);
        $another = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $another['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => 'zhfdzjkdf',
            'id_emergency_contact' => 'tfgh'
        ]));
        $this->userNotFound($response);
    }

    public function test_r2c8UserNotInAdminSdmPemilikMencobaMengaksesHalamanUbahDataEcMilikPegawaiLain_Test(): void
    {
        $nonRole = $this->define_account(false,false, true, 'nonrole@yyy',true,false);
        $another = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $another['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonRole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.updateView', [
            'id_User' => 'zhfdzjkdf',
            'id_emergency_contact' => 'tfgh'
        ]));
        $this->userOutAkses($response);
    }

    public function test_r2c9UserYangBelumLoginAccessEditEcPage_Test(): void
    {
        $response = $this->getJson(route('profile.emergency-contacts.updateView', [
            'id_User' => 'zhfdzjkdf',
            'id_emergency_contact' => 'tfgh'
        ]));
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }



    public function userNotFound($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'User tidak ditemukan!.');
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
