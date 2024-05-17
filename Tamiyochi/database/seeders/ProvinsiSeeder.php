<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('provinsi')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/provinsi.json'));
        $provinsis = json_decode($json, true);

        $payload = [];
        foreach ($provinsis as $provinsi) {
            $payload[] = [
                'id' => $provinsi['id'],
                'name' => $provinsi['name']
            ];
        }
        DB::table('provinsi')->insert($payload);
    }
}
