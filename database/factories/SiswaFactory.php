<?php

namespace Database\Factories;

use App\Models\Mentor;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'tanggal_lahir' => fake()->dateTimeBetween('-22 year', '-20 years')->format('Y-m-d'),
            'jurusan' => fake()->randomElement([
                'Teknik Informatika', 'Teknik Industri', 'Teknik Mesin', 'Teknik Lingkungan'
            ]),
            'nilai' => fake()->numberBetween(70, 100),
            'mentor_id' => Mentor::inRandomOrder()->first()->id
        ];
    }
}
