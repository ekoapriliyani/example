<?php

namespace Database\Factories;

use App\Models\Mesin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mesin>
 */
class MesinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_mesin' => fake()->numberBetween(10000, 9999)
            
        ];
    }
}
