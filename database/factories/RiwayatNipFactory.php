<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatNip>
 */
class RiwayatNipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip'=>fake()->numerify('################'),
            'status_pegawai_id'=>null,
            'sk_ypt_id'=>null,
            'users_id'=>null,
            'tmt_mulai'=>fake()->date(),
            'is_active'=>true,
            'created_at' => now(),
            'updated_at' => now(),  
        ];
    }
}
