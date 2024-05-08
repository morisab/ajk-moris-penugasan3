<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('penerbit')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/penerbit.json'));
        $penerbits = json_decode($json, true);

        $payload = [];
        foreach ($penerbits as $penerbit) {
            $payload[] = [
                'id' => $penerbit['id'],
                'nama' => $penerbit['nama']
            ];
        }
        DB::table('penerbit')->insert($payload);
    }
}
