<?php

namespace Database\Factories;

use App\Models\KnowledgeItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keyword>
 */
class KeywordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $words = [
            'moodle',
            'login',
            'exam',
            'registration',
            'tuition',
            'payment',
            'student-service',
            'schedule',
            'certificate',
            'portal',
        ];

        return [
            'knowledge_item_id' => KnowledgeItem::factory(),
            'word' => fake()->randomElement($words),
            'weight' => fake()->numberBetween(1, 5),
        ];
    }
}
