<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


abstract class TestCase extends BaseTestCase
{
    // use RefreshDatabase;

    protected $connectionsToTransact = ['mysql', 'dupak'];

    public function define_account($is_admin = false, $is_new = false, $email_verif = false, $email = 'admin@telkomuniversity.ac.id', $is_active = true)
    {
        $date_verif_email = $email_verif == true ? now() : null;
        $user = User::factory()->create([
            'nama_lengkap' => 'Admin',
            'email_institusi' => $email,
            // 'email_pribadi' => 'mardiahresti@gmail.com',
            // 'password' => 'CobaIni',
            'is_admin' => $is_admin,
            'is_new' => $is_new,
            'is_active' => $is_active,
            'email_verified_at' => $date_verif_email,
        ]);
        return $user;
    }
}
