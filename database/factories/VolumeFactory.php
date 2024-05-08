<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volume>
 */
class VolumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seris = DB::table('seri')->select('id')->get();
        $harga_sewa = [10000, 12000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000];
        $jumlah_tersedia = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        return [
            'volume' => rand(1, 10),
            'jumlah_tersedia' => $jumlah_tersedia[rand(0, 9)],
            'harga_sewa' => $harga_sewa[rand(0, 9)],
            'seri_id' => $seris->random()->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
