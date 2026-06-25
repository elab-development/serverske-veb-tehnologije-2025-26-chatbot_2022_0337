<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\KnowledgeItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $validated = $request->validate([
            'question' => ['required', 'string'],
        ]);

        $userQuestion = $validated['question'];
        $lowerQuestion = Str::lower($userQuestion);

        $knowledgeItems = KnowledgeItem::query()
            ->with('category', 'keywords')
            ->where('is_active', true)
            ->get();

        $bestItem = null;
        $bestScore = 0;
        $bestMatchedKeywords = [];

        foreach ($knowledgeItems as $knowledgeItem) {
            $score = 0;
            $matchedKeywords = [];

            foreach ($knowledgeItem->keywords as $keyword) {
                $keywordWord = Str::lower($keyword->word);

                if ($keywordWord !== '' && Str::contains($lowerQuestion, $keywordWord)) {
                    $score += $keyword->weight;
                    $matchedKeywords[] = $keyword->word;
                }
            }

            if ($this->containsUsefulText($lowerQuestion, $knowledgeItem->question)) {
                $score += 1;
            }

            if ($this->containsUsefulText($lowerQuestion, $knowledgeItem->title)) {
                $score += 1;
            }

            if ($score > $bestScore) {
                $bestItem = $knowledgeItem;
                $bestScore = $score;
                $bestMatchedKeywords = $matchedKeywords;
            }
        }

        if ($bestItem === null || $bestScore === 0) {
            return response()->json([
                'message' => 'Chatbot trenutno nema odgovor na ovo pitanje.',
                'answer' => null,
                'suggested_questions' => [],
            ]);
        }

        $suggestedQuestions = KnowledgeItem::query()
            ->where('is_active', true)
            ->where('category_id', $bestItem->category_id)
            ->where('id', '!=', $bestItem->id)
            ->orderByDesc('priority')
            ->limit(3)
            ->pluck('question')
            ->values();

        if ($request->user()) {
            ChatMessage::create([
                'user_id' => $request->user()->id,
                'knowledge_item_id' => $bestItem->id,
                'user_message' => $userQuestion,
                'bot_response' => $bestItem->answer,
                'match_score' => $bestScore,
            ]);
        }

        return response()->json([
            'message' => 'Odgovor je pronađen.',
            'question' => $bestItem->question,
            'answer' => $bestItem->answer,
            'matched_keywords' => array_values(array_unique($bestMatchedKeywords)),
            'match_score' => $bestScore,
            'suggested_questions' => $suggestedQuestions,
        ]);
    }

    private function containsUsefulText(string $question, string $text): bool
    {
        $text = Str::lower($text);

        if (Str::length($text) < 4) {
            return false;
        }

        return Str::contains($question, $text) || Str::contains($text, $question);
    }
}
