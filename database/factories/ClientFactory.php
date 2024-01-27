<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'sumber' => $this->faker->randomElement(['iklan', 'teman', 'wa']),
            'wa' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'alamat' => $this->faker->address(),
            'nomor_rekening' => $this->faker->randomNumber(),
            'nama_rekening' => $this->faker->name(),
            'nasabah_bank' => $this->faker->name(),
        ];
    }
}
