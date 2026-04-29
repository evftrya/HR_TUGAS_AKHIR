<?php

namespace Tests\Feature;

use App\Models\Emergency_contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmergencyContactAksesHalamanLihatDataEmergencyContactTest extends TestCase
{
    use DatabaseTransactions;



    public function test_akses_halaman_lihat_emergency_kontak_tanpa_login(): void
    {
        // $make_another_user = $this->define_account(true,false,true,'ownerec@yyy',true);
        // // dd($make_another_user);
        // $make_ec = Emergency_contact::factory()->create(['users_id' => $make_another_user->id, 'telepon' => '08972529100']);
        // dd($make_ec);
        $response = $this->getJson(route('profile.emergency-contacts.list', [
            'id_User' => 'sdhjkdkfgjd',
        ]));
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
        // dd($response[0]);
        // $this->assertNotEquals(200, $response->getStatusCode());

    }


    public function test_akses_halaman_lihat_emergency_kontak_dengan_sudah_login_and_admin_role_bukan_pemilik_data(): void
    {
        $user_owner = $this->define_account(true,false,true,'ownerec@yyy',true);
        $user_not_owner_but_admin = $this->define_account(true,false,true,'admin@yyy',true);
        // dd($make_another_user);
        $make_ec = Emergency_contact::factory()->create(['users_id' => $user_owner->id, 'telepon' => '08972529100']);
        // dd($make_ec);

        $admin_login = $this->post(route('login.store'), [
            'email_institusi' => 'admin@yyy',
            'password' => 'password123',
        ]);


        $response = $this->get(route('profile.emergency-contacts.list', [
            'id_User' => $user_owner->id,
        ]));

        dd($response[0]);

        // $response->assertJson([
        //     'message' => 'Unauthenticated.',
        // ]);
        // dd($response[0]);
        // $this->assertNotEquals(200, $response->getStatusCode());

    }
}
