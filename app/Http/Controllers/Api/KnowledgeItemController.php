<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KnowledgeItemResource;
use App\Models\KnowledgeItem;
use Illuminate\Http\Request;

class KnowledgeItemController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'is_active' => ['nullable', 'in:0,1,true,false'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = KnowledgeItem::query()
            ->with('category', 'keywords')
            ->when($validated['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('question', 'like', "%{$search}%")
                        ->orWhere('answer', 'like', "%{$search}%")
                        ->orWhereHas('keywords', function ($query) use ($search) {
                            $query->where('word', 'like', "%{$search}%");
                        });
                });
            })
            ->when($validated['category_id'] ?? null, function ($query, int $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->has('is_active'), function ($query) use ($request) {
                $query->where('is_active', $request->boolean('is_active'));
            })
            ->orderByDesc('priority')
            ->orderByDesc('created_at');

        $knowledgeItems = $query->paginate($validated['per_page'] ?? 15);

        return response()->json([
            'data' => KnowledgeItemResource::collection($knowledgeItems->items()),
            'meta' => [
                'current_page' => $knowledgeItems->currentPage(),
                'from' => $knowledgeItems->firstItem(),
                'last_page' => $knowledgeItems->lastPage(),
                'per_page' => $knowledgeItems->perPage(),
                'to' => $knowledgeItems->lastItem(),
                'total' => $knowledgeItems->total(),
            ],
            'links' => [
                'first' => $knowledgeItems->url(1),
                'last' => $knowledgeItems->url($knowledgeItems->lastPage()),
                'prev' => $knowledgeItems->previousPageUrl(),
                'next' => $knowledgeItems->nextPageUrl(),
            ],
        ]);
    }

    public function show(KnowledgeItem $knowledgeItem)
    {
        $knowledgeItem->load('category', 'keywords');

        return response()->json([
            'data' => new KnowledgeItemResource($knowledgeItem),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'priority' => ['sometimes', 'integer', 'min:0', 'max:255'],
        ]);

        $knowledgeItem = KnowledgeItem::create($validated);
        $knowledgeItem->load('category', 'keywords');

        return response()->json([
            'message' => 'Knowledge item created successfully.',
            'data' => new KnowledgeItemResource($knowledgeItem),
        ], 201);
    }

    public function update(Request $request, KnowledgeItem $knowledgeItem)
    {
        $validated = $request->validate([
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'question' => ['sometimes', 'required', 'string'],
            'answer' => ['sometimes', 'required', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'priority' => ['sometimes', 'integer', 'min:0', 'max:255'],
        ]);

        $knowledgeItem->update($validated);
        $knowledgeItem->load('category', 'keywords');

        return response()->json([
            'message' => 'Knowledge item updated successfully.',
            'data' => new KnowledgeItemResource($knowledgeItem),
        ]);
    }

    public function destroy(KnowledgeItem $knowledgeItem)
    {
        $knowledgeItem->delete();

        return response()->json([
            'message' => 'Knowledge item deleted successfully.',
        ]);
    }
}
