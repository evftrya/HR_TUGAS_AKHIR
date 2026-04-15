<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatJabatanFungsionalTpa>
 */
class RiwayatJabatanFungsionalKeahlianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ref_jfk_id' => null,
            'tpa_id' => null,
            'tmt_mulai' => $this->faker->date(),
            'tmt_selesai' => null,
            // 'sk_llkdikti_id' => null,
            'sk_pengakuan_ypt_id' => null,
        ];
    }
    protected $model = \App\Models\RiwayatJabatanFungsionalKeahlian::class;
}
