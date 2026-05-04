<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmergencyContactAddDataEmergencyContactAksesHalamanTest extends TestCase
{
    use DatabaseTransactions;

    public function test_EMERGENCYCONTACT_AKSES_HALAMAN_TAMBAH_DATA(): void
    {
        $this->assertTrue(true);
    }
    /**
     * A basic feature test example.
     */
    public function test_r2d1AdminMengaksesHalaman_Test(): void
    {
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2d2PemilikMengaksesHalamanInputEcMilikSendiri_Test(): void
    {

        $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2d3SdmMengaksesMilikPegawai_Test(): void
    {
        $user_admin = $this->define_account(false,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2d4UserValidRoleAksesButIdUserNotRegisteredOrWrong_Test(): void
    {
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => 'xyz',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2d5AdminAksesMilikSendiriButIdUserNotRegisteredOrWrong_Test(): void
    {
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        // $other = $this->define_account(false,false, true, 'other@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => 'xyz',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2d6AdminAksesMilikPegawaiButIdUserNotRegisteredOrWrong_Test(): void
    {
        $user_admin = $this->define_account(true,false, true, 'admin@yyy',true,false);
        $other = $this->define_account(false,false, true, 'other@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $other['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => 'xyz',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2d7UserWhosTheRoleNotOneOfAdminSdmOwnerAccesAnotherNewEcPage_Test(): void
    {
        $nonRole = $this->define_account(false,false, true, 'nonrole@yyy',true,false);
        $other = $this->define_account(false,false, true, 'other@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $other['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $nonRole['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => $other['id'],
        ]));
        // dd($response);

        $this->userOutAkses($response);
    }

    public function test_r2d8UserYangBelumLoginAccessNewEcPage_Test(): void
    {
        $response = $this->getJson(route('profile.emergency-contacts.new', [
            'id_User' => 'sdhjkdkfgjd',
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
        $response->assertSessionHas('error_alert', 'Anda hanya boleh menambahkan data anda sendiri!.');
    }

    public function userFound($response)
    {
        $response->assertStatus(200);
        $response->assertViewIs('kelola_data.emergency_contact.input');
    }
}
