<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = [
            'Moodle',
            'Exams',
            'Tuition',
            'Student Service',
            'Schedule',
            'Library',
            'Scholarships',
            'Enrollment',
            'Internships',
            'Email Account',
        ];

        $name = fake()->unique()->randomElement($names);

        return [
            'name' => $name,
            'description' => fake()->sentence(12),
        ];
    }
}
