<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ProjectType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'client_id' => Client::all()->random()->id,
            'project_type_id' => ProjectType::all()->random()->id,
            'status' => $this->faker->randomElement(['penawaran', 'deal', 'finish', 'cancel']),
        ];
    }
}