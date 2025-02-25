<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Units>
 */
class UnitsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "national_code" => fake()->unique(),
            "title" => fake()->word(),
            "tga_status" => fake()->text(),
            "state_code" => fake()->regexify('[A-Z]{3}[0-9]{2}'),
            "nominal_hours" => fake()->numberBetween(1,200)
        ];
    }
}
