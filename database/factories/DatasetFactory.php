<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Dataset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dataset>
 */
class DatasetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => 1,
            'name' => $this->faker->words(3, true) . ' Schema',
            'description' => $this->faker->sentence(),
            'sql_script' => "CREATE TABLE users (\n    id INT PRIMARY KEY,\n    name VARCHAR(100)\n);"
        ];
    }
}
