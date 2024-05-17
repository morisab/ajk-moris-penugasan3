<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriPenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seri_penulis')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/seri_penulis.json'));
        $seri_penuliss = json_decode($json, true);

        $payload = [];
        foreach ($seri_penuliss as $seri_penulis) {
            $payload[] = [
                'id' => $seri_penulis['id'],
                'seri_id' => $seri_penulis['seri_id'],
                'penulis_id' => $seri_penulis['penulis_id']
            ];
        }
        DB::table('seri_penulis')->insert($payload);
    }
}
