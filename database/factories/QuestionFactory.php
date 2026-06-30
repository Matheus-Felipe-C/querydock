<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topics = [
            'joins',
            'aggregation',
            'group-by',
            'subqueries',
            'window-functions',
            'cte',
            'indexes',
        ];
 
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(4),
            'difficulty' => fake()->randomElement([
                'easy',
                'medium',
                'hard',
            ]),
            'course_id' => 1,
            'topics' => fake()->randomElements($topics, rand(1, 3)),
        ];
    }
}
