<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CoursesFactory extends Factory
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
            "aqf_level" => fake()->text(),
            "title" => fake()->word(),
            "tga_status" => fake()->text(),
            "nominal_hours" => fake()->numberBetween(1,2000),
            "type" => fake()->numberBetween(1,200),
            "qa" => fake()->regexify('[A-Z]{3}[0-9]{1}'),
            "state_code" => fake()->regexify('[A-Z]{3}[0-9]{1}'),
            "nat_code" => fake()->regexify('[A-Z]{3}[0-9]{5}'),
            "nat_title" => fake()->text(),
            "nat_code_title" => fake()->text(),
        ];
    }
}
