<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatPangkatGolongan>
 */
class RiwayatPangkatGolonganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            // Foreign keys (nullable)
            'pangkat_golongan_id' => null, // nanti bisa diisi manual di seeder
            'sk_llkdikti_id' => null,
            // 'sk_pengakuan_ypt_id' => null,

            // tmt_mulai: tanggal mulai berlaku pangkat
            'tmt_mulai' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'tmt_selesai' => null,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
