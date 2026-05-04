<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User random
        // User::factory()->count(2)->create();
        // User khusus Admin (dibuat sekali saja)
        User::factory()->admin()->create();
        User::factory()->yanto()->create();
    }
}
