<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RefJabatanFungsionalAkademik>
 */
class RefJabatanFungsionalAkademikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_jabatan' => $this->faker->jobTitle(),
        ];
    }
    protected $model = \App\Models\RefJabatanFungsionalAkademik::class;
    
    
}
