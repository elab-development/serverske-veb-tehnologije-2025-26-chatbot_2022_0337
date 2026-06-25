<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KnowledgeItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'keywords' => $this->whenLoaded('keywords'),
            'title' => $this->title,
            'question' => $this->question,
            'answer' => $this->answer,
            'is_active' => (bool) $this->is_active,
            'priority' => $this->priority,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
