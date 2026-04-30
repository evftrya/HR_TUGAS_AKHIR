<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\formation>
 */
class FormationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_formasi' => $this->faker->word(),
            'level_id' => null,
            'atasan_formasi_id' => null,
            'work_position_id' => null,
            // 'bagian' => null,
            // 'prodi' => null,
            // 'fakultas' => null,
            'kuota' => $this->faker->numberBetween(1, 10),
        ];
    }
}
