<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Yanto',
        //     'email' => 'yanto@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'remember_token' => Str::random(10),
        // ]);

        $this->call([
            // SiswaSeeder::class,
            // FlightSeeder::class,
            // MaterialSeeder::class,
            UserSeeder::class
        ]);


        // // Buat 5 dosen
        // $dosen = Dosen::factory(5)->create();

        // // Buat 10 mata kuliah, masing-masing terkait dosen
        // $mataKuliah = MataKuliah::factory(10)->create();

        // // Buat 6 kelas
        // $kelas = Kelas::factory(6)->create();

        // // Buat 20 mahasiswa
        // $mahasiswa = Mahasiswa::factory(20)->create();

        // Assign mahasiswa ke kelas (pivot)
        // $kelas->each(function ($k) use ($mahasiswa) {
        //     $k->mahasiswa()->attach(
        //         $mahasiswa->random(5)->pluck('id')->toArray()
        //     );
        // });

    }
}
