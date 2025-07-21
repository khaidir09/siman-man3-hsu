<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'nama_lengkap' dan 'user_id' akan diisi dari UserFactory
            'nisn' => fake()->numerify('##########'), // Membuat 10 digit angka acak [1]
            'room_id' => fake()->numberBetween(1, 12), // Membuat angka acak antara 1 dan 12 [2]
            'status' => 'Aktif',
        ];
    }
}
