<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VolumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('volume')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/volume.json'));
        $volumes = json_decode($json, true);

        $payload = [];
        foreach ($volumes as $volume) {
            $payload[] = [
                'id' => $volume['id'],
                'volume' => $volume['volume'],
                'jumlah_tersedia' => $volume['jumlah_tersedia'],
                'harga_sewa' => $volume['harga_sewa'],
                'seri_id' => $volume['seri_id'],
            ];
        }
        DB::table('volume')->insert($payload);
    }
}
