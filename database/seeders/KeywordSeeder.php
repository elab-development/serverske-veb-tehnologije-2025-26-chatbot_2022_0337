<?php

namespace Database\Seeders;

use App\Models\Keyword;
use App\Models\KnowledgeItem;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keywordsByTitle = [
            'Moodle login problem' => ['moodle', 'login', 'access', 'password', 'account'],
            'Missing Moodle course' => ['moodle', 'course', 'missing', 'teacher'],
            'Submitting Moodle assignment' => ['assignment', 'submit', 'upload', 'deadline'],
            'Moodle password reset' => ['password', 'reset', 'moodle', 'credentials'],
            'Course materials on Moodle' => ['materials', 'lecture', 'course', 'moodle'],
            'Exam registration deadline' => ['exam', 'registration', 'deadline', 'session'],
            'Cancel exam registration' => ['exam', 'cancel', 'registration', 'deadline'],
            'Exam results' => ['results', 'grade', 'exam', 'portal'],
            'Exam schedule' => ['exam', 'schedule', 'date', 'session'],
            'Exam rules' => ['exam', 'rules', 'student-id', 'document'],
            'Tuition payment confirmation' => ['tuition', 'payment', 'confirmation', 'portal'],
            'Tuition installments' => ['tuition', 'installments', 'payment', 'fee'],
            'Payment instructions' => ['payment', 'instructions', 'tuition', 'account'],
            'Late tuition payment' => ['late', 'payment', 'tuition', 'obligation'],
            'Tuition invoice' => ['invoice', 'proof', 'payment', 'tuition'],
            'Student certificate request' => ['certificate', 'request', 'student-service', 'status'],
            'Change personal data' => ['personal-data', 'change', 'documents', 'student-service'],
            'Student record book' => ['record', 'student-service', 'status', 'documents'],
            'Document pickup' => ['documents', 'pickup', 'working-hours', 'student-service'],
            'Enrollment verification' => ['enrollment', 'verification', 'status', 'portal'],
            'Class schedule changes' => ['schedule', 'changes', 'classes', 'portal'],
            'Consultation hours' => ['consultations', 'professor', 'hours', 'course'],
            'Classroom information' => ['classroom', 'room', 'schedule', 'class'],
            'Online classes' => ['online', 'classes', 'moodle', 'email'],
            'Schedule conflicts' => ['schedule', 'conflict', 'overlap', 'coordinator'],
        ];

        foreach ($keywordsByTitle as $title => $words) {
            $knowledgeItem = KnowledgeItem::where('title', $title)->firstOrFail();

            foreach ($words as $index => $word) {
                Keyword::updateOrCreate(
                    [
                        'knowledge_item_id' => $knowledgeItem->id,
                        'word' => $word,
                    ],
                    [
                        'weight' => max(1, 5 - $index),
                    ]
                );
            }
        }
    }
}
