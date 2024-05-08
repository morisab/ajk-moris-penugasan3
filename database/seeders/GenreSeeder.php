<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('genre')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/genre.json'));
        $genres = json_decode($json, true);

        $payload = [];
        foreach ($genres as $genre) {
            $payload[] = [
                'id' => $genre['id'],
                'nama' => $genre['nama']
            ];
        }
        DB::table('genre')->insert($payload);
    }
}
