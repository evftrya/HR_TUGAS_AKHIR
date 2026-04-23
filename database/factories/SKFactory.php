<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SK>
 */
class SKFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {



        // $tipe = $this->faker->randomElement(['LLDIKTI', 'Pengakuan YPT']);
        // $kode = $tipe == 'LLDIKTI' ? 'LLD' : 'YPT';
        return [
            'tipe_dokumen' => $this->faker->randomElement(['SK', 'AMANDEMEN']),
            'tipe_sk' => $this->faker->randomElement(['LLDIKTI', 'Pengakuan YPT', '-']),
            'no_sk' => function (array $attributes) {
                $kode = $attributes['tipe_sk'] == 'LLDIKTI' ? 'LLD' : 'YPT';
                return fake()->numerify('SK-###/' . $kode);
            },
            'tmt_mulai' => $this->faker->optional()->date(),
            'file_sk' => 'SK/Pemetaan/Pemetaan_LLDIKTI_SIMDK-Struktur-1776540508226.png',
            'keterangan' => 'keterangan',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function AMANDEMEN()
    {
        return $this->state(function () {
            return [
                'tipe_dokumen' => 'AMANDEMEN',
                'no_sk' => fake()->numerify('AMANDEMEN-####'),
                'tipe_sk' => '-',
            ];
        });
    }

    public function lldikti()
    {
        return $this->state(function () {
            return [
                'tipe_dokumen' => 'SK',
                'no_sk' => fake()->numerify('SK-####/LLKDIKTI'),
                'tipe_sk' => 'LLDIKTI',
            ];
        });
    }

    public function ypt()
    {
        return $this->state(function () {
            return [
                'tipe_dokumen' => 'SK',
                'no_sk' => fake()->numerify('SK-####/YPT'),
                'tipe_sk' => 'Pengakuan YPT',
            ];
        });
    }
}
