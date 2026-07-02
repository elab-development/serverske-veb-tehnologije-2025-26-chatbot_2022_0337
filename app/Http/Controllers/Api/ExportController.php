<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeItem;

class ExportController extends Controller
{
    public function knowledgeItems()
    {
        $fileName = 'knowledge-items-export-'.now()->format('Y-m-d-H-i-s').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'id',
                'category',
                'title',
                'question',
                'answer',
                'is_active',
                'priority',
                'keywords',
                'created_at',
                'updated_at',
            ]);

            KnowledgeItem::with(['category', 'keywords'])
                ->orderBy('id')
                ->chunk(100, function ($knowledgeItems) use ($handle) {
                    foreach ($knowledgeItems as $knowledgeItem) {
                        fputcsv($handle, [
                            $knowledgeItem->id,
                            $knowledgeItem->category?->name,
                            $knowledgeItem->title,
                            $knowledgeItem->question,
                            $knowledgeItem->answer,
                            $knowledgeItem->is_active ? '1' : '0',
                            $knowledgeItem->priority,
                            $knowledgeItem->keywords->pluck('word')->implode(', '),
                            optional($knowledgeItem->created_at)->toDateTimeString(),
                            optional($knowledgeItem->updated_at)->toDateTimeString(),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}
