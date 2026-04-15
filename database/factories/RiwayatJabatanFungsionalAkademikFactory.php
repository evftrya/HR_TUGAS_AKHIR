<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatJabatanFungsionalAkademik>
 */
class RiwayatJabatanFungsionalAkademikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ref_jfa_id' => null,
            'dosen_id' => null,
            'tmt_mulai' => $this->faker->date(),
            'tmt_selesai' => null,
            'sk_llkdikti_id' => null,
            'sk_pengakuan_ypt_id' => null,
        ];
    }
    protected $model = \App\Models\RiwayatJabatanFungsionalAkademik::class;
}
