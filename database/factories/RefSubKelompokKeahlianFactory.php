<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RefSubKelompokKeahlian>
 */
class RefSubKelompokKeahlianFactory extends Factory
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
        'kode'      => fake()->unique()->bothify('??-###'),
        'deskripsi' => fake()->sentence(),
        'kk_id'     => null
    ];
    }
}
