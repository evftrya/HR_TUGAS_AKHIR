<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    use DatabaseTransactions;
    protected $connectionsToTransact = ['mysql', 'dupak'];
    /**
     * A basic feature test example.
     */

    public function define_account($is_admin = false, $is_new = false, $email_verif = false){
        $date_verif_email = $email_verif==true? null : now();
        $user = User::factory()->create([
            'nama_lengkap' => 'Admin',
            'email_institusi' => 'admin@telkomuniversity.ac.id',
            'email_pribadi' => 'mardiahresti@gmail.com',
            'password' => 'CobaIni',
            'is_admin' => $is_admin,
            'is_new' => $is_new,
            'email_verified_at' => $date_verif_email,
        ]);
    }

    public function test_login_success(): void
    {
        $response = $this->post(route('login.store'), [
            'email_institusi' => 'test@mail.com',
            'password' => '123456'
        ]);

        // dd($response);
        $response->assertStatus(200);
    }
}
