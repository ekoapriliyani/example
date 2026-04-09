<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            MentorSeeder::class,
            SiswaSeeder::class,
            FlightSeeder::class,
            MaterialSeeder::class
        ]);


        // Buat 5 dosen
        $dosen = Dosen::factory(5)->create();

        // Buat 10 mata kuliah, masing-masing terkait dosen
        $mataKuliah = MataKuliah::factory(10)->create();

        // Buat 6 kelas
        $kelas = Kelas::factory(6)->create();

        // Buat 20 mahasiswa
        $mahasiswa = Mahasiswa::factory(20)->create();

        // Assign mahasiswa ke kelas (pivot)
        $kelas->each(function ($k) use ($mahasiswa) {
            $k->mahasiswa()->attach(
                $mahasiswa->random(5)->pluck('id')->toArray()
            );
        });

    }
}
