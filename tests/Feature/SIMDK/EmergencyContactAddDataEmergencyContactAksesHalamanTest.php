<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmergencyContactAddDataEmergencyContactAksesHalamanTest extends TestCase
{
    public function test_EMERGENCYCONTACT_AKSES_HALAMAN_TAMBAH_DATA(): void
    {
        $this->assertTrue(true);
    }
    /**
     * A basic feature test example.
     */
    public function test_AdminMengaksesHalaman_Test(): void
    {
        $user_admin = $this->define_account(true, false, true, 'admin@yyy',true,true);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_admin['id'], 'telepon' => '08972529100']);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => $user_admin['email_institusi'],
            'password' => 'password123',
        ]);
        $response = $this->get(route('profile.emergency-contacts.new', [
            'id_User' => $make_ec['id'],
        ]));

        $this->userFound($response);
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
