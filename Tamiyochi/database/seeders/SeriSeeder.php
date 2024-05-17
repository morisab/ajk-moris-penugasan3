<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seri')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/seri.json'));
        $seris = json_decode($json, true);

        $payload = [];
        foreach ($seris as $seri) {
            $payload[] = [
                'id' => $seri['id'],
                'judul' => $seri['judul'],
                'sinopsis' => $seri['sinopsis'],
                'tahun_terbit' => $seri['tahun_terbit'],
                'skor' => $seri['skor'],
                'foto' => $seri['foto'],
                'penerbit_id' => $seri['penerbit_id']
            ];
        }
        DB::table('seri')->insert($payload);
    }
}
