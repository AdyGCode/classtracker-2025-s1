<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Package;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cluster>
 */
class ClusterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $unit = Unit::inRandomOrder()->first();
        return [
            "code" => fake()->unique(),
            "title" => fake()->word(),
            "qualification" => fake()->regexify('[A-Z]{3}[0-9]{5}'),
            "qualification_code" => fake()->regexify('[A-Z]{2}[0-9]{2}'),
            "unit_1" => fake()->regexify('[A-Z]{4}[0-9]{3}'), // Reference https://stackoverflow.com/questions/49464984/how-to-generate-random-string-using-laravel-faker
            "unit_2" => fake()->regexify('[A-Z]{4}[0-9]{3}'),
            "unit_3" => fake()->regexify('[A-Z]{4}[0-9]{3}'),
            "unit_4" => fake()->regexify('[A-Z]{4}[0-9]{3}'),
            'unit_id' => $this->faker->uuid,
        ];
    }
}
