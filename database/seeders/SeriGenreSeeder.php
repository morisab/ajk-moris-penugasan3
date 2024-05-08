<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seri_genre')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/seri_genre.json'));
        $seri_genres = json_decode($json, true);

        $payload = [];
        foreach ($seri_genres as $seri_genre) {
            $payload[] = [
                'id' => $seri_genre['id'],
                'seri_id' => $seri_genre['seri_id'],
                'genre_id' => $seri_genre['genre_id']
            ];
        }
        DB::table('seri_genre')->insert($payload);
    }
}
