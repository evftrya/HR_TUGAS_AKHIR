<?php

namespace Database\Seeders;

use App\Models\RefBagian;
use App\Models\RefJabatanFungsional;
use App\Models\RefJabatanFungsionalKeahlian;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{


    $path = database_path('sdm_new.sql');

    $sql = File::get($path);

    DB::unprepared($sql);

    $this->call([
        \Database\Seeders\FakultasSeeder::class,
        \Database\Seeders\RefKelompokKeahlianSeeder::class,
        \Database\Seeders\RefSubKelompokKeahlianSeeder::class,
        RefJenjangPendidikanSeeder::class,
        UserSeeder::class,
        RiwayatJenjangPendidikanSeeder::class,
        \Database\Seeders\UnitSeeder::class,
        \Database\Seeders\TargetKinerjaSeeder::class,
        \Database\Seeders\KontrakUnitSeeder::class,
        \Database\Seeders\TargetKinerjaHarianSeeder::class,
        \Database\Seeders\PelaporanPekerjaanSeeder::class,
    ]);


}

}
