<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            GenreSeeder::class,
            PenerbitSeeder::class,
            SeriSeeder::class,
            PenulisSeeder::class,
            GenreSeeder::class,
            SeriGenreSeeder::class,
            SeriPenulisSeeder::class,
            VolumeSeeder::class,
        ]);
    }
}
