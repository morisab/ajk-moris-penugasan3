<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Core\Domain\Models\User\UserId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => UserId::generate()->toString(),
            'kabupaten_id' => rand(1101, 1110),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'no_telp' => fake()->phoneNumber(),
            'user_type' => 'user',
            'age' => rand(18, 32),
            'image_url' => 'https://i.pravatar.cc/150?img=' . rand(1, 1000),
            'password' => Hash::make(Str::random(10)),
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
