<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatJenjangPendidikan>
 */
class RiwayatJenjangPendidikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bidang_pendidikan' => $this->faker->word(),
            'jurusan' => $this->faker->words(2, true),
            'nama_kampus' => $this->faker->company() . ' University',
            'alamat_kampus' => $this->faker->address(),
            'tahun_lulus' => $this->faker->year(),
            'nilai' => $this->faker->randomFloat(2, 2.00, 4.00),
            'gelar' => $this->faker->word(),
            'singkatan_gelar' => strtoupper($this->faker->lexify('???')),
            'ijazah' => $this->faker->optional()->lexify('ijazah_????????.pdf'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
