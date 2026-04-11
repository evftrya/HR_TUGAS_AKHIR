<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RefKelompokKeahlian>
 */
class RefKelompokKeahlianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'      => fake()->name(),
            'kode'      => fake()->unique()->lexify('???-####'),
            'deskripsi' => fake()->paragraph(),
        ];
    }
}
