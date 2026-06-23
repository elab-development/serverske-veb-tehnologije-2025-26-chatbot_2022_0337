<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KnowledgeItem>
 */
class KnowledgeItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $items = [
            [
                'title' => 'Moodle login problem',
                'question' => 'What should I do if I cannot log in to Moodle?',
                'answer' => 'Check your student email credentials first, then reset your password or contact Student Service if the problem continues.',
            ],
            [
                'title' => 'Exam registration deadline',
                'question' => 'When can I register an exam?',
                'answer' => 'Exam registration is usually available during the official registration period published before each exam session.',
            ],
            [
                'title' => 'Tuition payment confirmation',
                'question' => 'How can I check whether my tuition payment was recorded?',
                'answer' => 'You can check payment status through the student portal or ask Student Service to verify the payment.',
            ],
            [
                'title' => 'Class schedule changes',
                'question' => 'Where can I see changes in the class schedule?',
                'answer' => 'Schedule changes are published on the faculty website, notice board, or official student portal.',
            ],
            [
                'title' => 'Student certificate request',
                'question' => 'How do I request a student status certificate?',
                'answer' => 'Submit a request to Student Service and include the purpose of the certificate.',
            ],
        ];

        $item = fake()->randomElement($items);

        return [
            'category_id' => Category::factory(),
            'title' => $item['title'],
            'question' => $item['question'],
            'answer' => $item['answer'],
            'is_active' => true,
            'priority' => fake()->numberBetween(1, 5),
        ];
    }
}
