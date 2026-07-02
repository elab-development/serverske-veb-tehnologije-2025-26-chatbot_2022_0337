<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Keyword;
use App\Models\KnowledgeItem;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function overview()
    {
        $response = Cache::remember('statistics.overview', now()->addMinutes(10), function () {
            return [
                'message' => 'Statistika je uspešno učitana.',
                'data' => [
                    'total_users' => User::count(),
                    'total_categories' => Category::count(),
                    'total_knowledge_items' => KnowledgeItem::count(),
                    'active_knowledge_items' => KnowledgeItem::where('is_active', true)->count(),
                    'inactive_knowledge_items' => KnowledgeItem::where('is_active', false)->count(),
                    'total_keywords' => Keyword::count(),
                    'total_chat_messages' => ChatMessage::count(),
                    'average_match_score' => $this->formatScore(ChatMessage::avg('match_score')),
                ],
            ];
        });

        return response()->json($response);
    }

    public function categories()
    {
        $response = Cache::remember('statistics.categories', now()->addMinutes(10), function () {
            $statistics = Category::query()
                ->leftJoin('knowledge_items', 'categories.id', '=', 'knowledge_items.category_id')
                ->leftJoin('keywords', 'knowledge_items.id', '=', 'keywords.knowledge_item_id')
                ->leftJoin('chat_messages', 'knowledge_items.id', '=', 'chat_messages.knowledge_item_id')
                ->select([
                    'categories.id as category_id',
                    'categories.name as category_name',
                    DB::raw('COUNT(DISTINCT knowledge_items.id) as knowledge_items_count'),
                    DB::raw('COUNT(DISTINCT CASE WHEN knowledge_items.is_active = 1 THEN knowledge_items.id END) as active_knowledge_items_count'),
                    DB::raw('COUNT(DISTINCT keywords.id) as keywords_count'),
                    DB::raw('COUNT(DISTINCT chat_messages.id) as chat_messages_count'),
                ])
                ->groupBy('categories.id', 'categories.name')
                ->orderBy('categories.name')
                ->get()
                ->map(function ($category) {
                    return [
                        'category_id' => $category->category_id,
                        'category_name' => $category->category_name,
                        'knowledge_items_count' => (int) $category->knowledge_items_count,
                        'active_knowledge_items_count' => (int) $category->active_knowledge_items_count,
                        'keywords_count' => (int) $category->keywords_count,
                        'chat_messages_count' => (int) $category->chat_messages_count,
                    ];
                });

            return [
                'message' => 'Statistika je uspešno učitana.',
                'data' => $statistics,
            ];
        });

        return response()->json($response);
    }

    public function chatMessages()
    {
        $response = Cache::remember('statistics.chat-messages', now()->addMinutes(10), function () {
            $totalChatMessages = ChatMessage::count();
            $messagesWithMatchedAnswer = ChatMessage::whereNotNull('knowledge_item_id')
                ->whereNotNull('bot_response')
                ->count();

            return [
                'message' => 'Statistika je uspešno učitana.',
                'data' => [
                    'total_chat_messages' => $totalChatMessages,
                    'average_match_score' => $this->formatScore(ChatMessage::avg('match_score')),
                    'highest_match_score' => $this->formatScore(ChatMessage::max('match_score')),
                    'lowest_match_score' => $this->formatScore(ChatMessage::min('match_score')),
                    'messages_with_matched_answer' => $messagesWithMatchedAnswer,
                    'messages_without_matched_answer' => $totalChatMessages - $messagesWithMatchedAnswer,
                ],
            ];
        });

        return response()->json($response);
    }

    private function formatScore($score)
    {
        return $score === null ? 0 : round((float) $score, 2);
    }
}
