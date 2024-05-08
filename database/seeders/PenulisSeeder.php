<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('penulis')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/penulis.json'));
        $penuliss = json_decode($json, true);

        $payload = [];
        foreach ($penuliss as $penulis) {
            $payload[] = [
                'id' => $penulis['id'],
                'nama_depan' => $penulis['nama_depan'],
                'nama_belakang' => $penulis['nama_belakang'],
                'peran' => $penulis['peran']
            ];
        }
        DB::table('penulis')->insert($payload);
    }
}
