<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MataKuliah>
 */
class MataKuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => strtoupper($this->faker->unique()->lexify('MK???')),
            'nama' => $this->faker->sentence(2),
            'dosen_id' => Dosen::factory(),
        ];
    }
}
