<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
        'role' => User::INSPECTOR,
    ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => User::ADMINISTRATOR,
            'password' => Hash::make('Beva2095'),
        ]);
    }

    public function yanto(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Yanto',
            'email' => 'yanto@gmail.com',
            'role' => User::INSPECTOR,
            'password' => Hash::make('12345678'),
        ]);
    }

    public function didik(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Didik',
            'email' => 'didik@gmail.com',
            'role' => User::MANAGER,
            'password' => Hash::make('Beva2095'),
        ]);
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
