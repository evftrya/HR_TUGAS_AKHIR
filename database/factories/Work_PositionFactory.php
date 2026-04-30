<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work_Position>
 */
class Work_PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => strtoupper(fake()->lexify('???')),
            'position_name' => fake()->word(),
            'type_work_position' => 'Bagian',
            'type_pekerja' => 'Both',
        ];
    }
}
