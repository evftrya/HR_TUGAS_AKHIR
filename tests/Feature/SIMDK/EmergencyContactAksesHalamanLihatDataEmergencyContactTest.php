<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmergencyContactAksesHalamanLihatDataEmergencyContactTest extends TestCase
{
    use DatabaseTransactions;

    public function test_EMERGENCYCONTACT(): void
    {
        $this->assertTrue(true);
    }

    public function test_r2a1AksesTanpaLogin(): void
    {
        $response = $this->getJson(route('profile.emergency-contacts.list', [
            'id_User' => 'sdhjkdkfgjd',
        ]));
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_r2a2LoginBukanSalahSatuDariAdminSdmPemilik(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_not_owner_not_sdm_not_admin = $this->define_account(false, false, true, 'nobody@yyy', true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner->id, 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => 'nobody@yyy',
            'password' => 'password123',
        ]);

        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_owner['id'],
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'Anda hanya boleh menambahkan data anda sendiri!.');
    }

    public function test_r2a3LoginStaffSdmDenganIdPegawaiTidakTerdaftar(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_not_owner_but_admin = $this->define_account(true, false, true, 'admin@yyy', true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner->id, 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => 'admin@yyy',
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'jSHdjshjdkjasda',
        ]));
        $this->userNotFound($response);
    }

    public function test_r2a4LoginStaffSdmDenganIdPegawaiTerdaftar(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_not_owner_but_admin = $this->define_account(true, false, true, 'admin@yyy', true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner->id, 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => 'admin@yyy',
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_owner['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2a5LoginPemilikDataDenganIdPegawaiTidakTerdaftar(): void
    {
        $admin_and_owner = $this->define_account(false, false, true, 'admin@yyy', true, false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $admin_and_owner->id, 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => 'admin@yyy',
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'zkdjdhfksjhdfkjshd',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2a6LoginPemilikDataDenganIdPegawaiTerdaftar(): void
    {
        $admin_and_owner = $this->define_account(false, false, true, 'admin@yyy', true, false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $admin_and_owner->id, 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => 'admin@yyy',
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $admin_and_owner['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2a7LoginPemilikDataDanStaffSdmDenganIdPegawaiTidakTerdaftar(): void
    {
        $user_sdm = $this->define_account(false, false, true, 'admin@yyy', true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_sdm['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'kdjdfhksedfse',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2a8LoginPemilikDataDanStaffSdmDenganIdPegawaiTerdaftarLoginPemilikDataDanStaffSdmDenganIdPegawaiTerdaftar(): void
    {
        $user_sdm = $this->define_account(false, false, true, 'admin@yyy', true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_sdm['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_sdm['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_sdm['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2a9LoginAdminDenganIdPegawaiTidakTerdaftar(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'jhsgjhadgjwsda',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2a10LoginAdminDenganIdPegawaiTerdaftar(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2a11LoginAdminDanStaffSdmDenganIdPegawaiTidakTerdaftar(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'jhsgjhadgjwsda',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2a12LoginAdminDanStaffSdmDenganIdPegawaiTerdaftar(): void
    {
        $user_owner = $this->define_account(true, false, true, 'ownerec@yyy', true);
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2a13LoginAdminDanPemilikDataDenganIdPegawaiTidakTerdaftar(): void
    {
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'jhsgjhadgjwsda',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2a14LoginAdminDanPemilikDataDenganIdPegawaiTerdaftar(): void
    {
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,false);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function test_r2a15LoginAdminPemilikDataDanStaffSdmDenganIdPegawaiTidakTerdaftar(): void
    {
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => 'fghjklkuytrfghj',
        ]));

        $this->userNotFound($response);
    }

    public function test_r2a16LoginAdminPemilikDataDanStaffSdmDenganIdPegawaiTerdaftar(): void
    {
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_admin['id'],
        ]));

        $this->userFound($response);
    }

    public function userNotFound($response)
    {
        $response->assertRedirect();
        $response->assertSessionHas('error_alert', 'User tidak ditemukan!.');
    }

    public function userFound($response)
    {
        $response->assertStatus(200);
        $response->assertViewIs('kelola_data.emergency_contact.list');
    }
}
