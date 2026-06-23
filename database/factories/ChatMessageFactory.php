<?php

namespace Database\Factories;

use App\Models\KnowledgeItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $messages = [
            [
                'user_message' => 'I cannot access Moodle. What should I do?',
                'bot_response' => 'Please check your student email credentials and try resetting your password. If that does not work, contact Student Service.',
            ],
            [
                'user_message' => 'When is the exam registration deadline?',
                'bot_response' => 'Exam registration deadlines are published before each exam session on the student portal.',
            ],
            [
                'user_message' => 'How do I check my tuition payment?',
                'bot_response' => 'You can check the payment status in the student portal or ask Student Service for confirmation.',
            ],
            [
                'user_message' => 'Where can I see my class schedule?',
                'bot_response' => 'The class schedule is available on the faculty website and student portal.',
            ],
        ];

        $message = fake()->randomElement($messages);

        return [
            'user_id' => User::factory(),
            'knowledge_item_id' => KnowledgeItem::factory(),
            'user_message' => $message['user_message'],
            'bot_response' => $message['bot_response'],
            'match_score' => fake()->numberBetween(60, 100),
        ];
    }
}
