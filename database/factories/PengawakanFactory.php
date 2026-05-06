<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\pengawakan>
 */
class PengawakanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'users_id' => \App\Models\User::inRandomOrder()->first()->id,
            'formasi_id' => \App\Models\Formation::inRandomOrder()->first()->id,
            'sk_ypt_id' => null,
            'tmt_mulai' => $this->faker->date(),
            'tmt_selesai' => null,
        ];
    }
}
