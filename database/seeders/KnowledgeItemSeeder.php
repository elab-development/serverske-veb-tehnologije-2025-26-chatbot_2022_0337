<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\KnowledgeItem;
use Illuminate\Database\Seeder;

class KnowledgeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemsByCategory = [
            'Moodle' => [
                ['Moodle login problem', 'What should I do if I cannot log in to Moodle?', 'Check your student email credentials first, then reset your password or contact Student Service if the problem continues.', 5],
                ['Missing Moodle course', 'Why is one of my courses not visible on Moodle?', 'A course may be hidden until the teacher enables it. Contact the course teacher or Student Service if the course should already be available.', 4],
                ['Submitting Moodle assignment', 'How do I submit an assignment on Moodle?', 'Open the course page, choose the assignment activity, upload the required file, and confirm the submission before the deadline.', 4],
                ['Moodle password reset', 'How can I reset my Moodle password?', 'Use the password reset option connected to your student account or request help from Student Service.', 3],
                ['Course materials on Moodle', 'Where can I find lecture materials on Moodle?', 'Lecture materials are usually available inside the course section after the teacher uploads them.', 3],
            ],
            'Exams' => [
                ['Exam registration deadline', 'When can I register an exam?', 'Exam registration is available during the official registration period published before each exam session.', 5],
                ['Cancel exam registration', 'Can I cancel my exam registration?', 'Exam registration can usually be cancelled before the cancellation deadline in the student portal.', 4],
                ['Exam results', 'Where can I see my exam results?', 'Exam results are published through the student portal, Moodle, or by the course teacher.', 4],
                ['Exam schedule', 'Where can I find the exam schedule?', 'The exam schedule is published on the faculty website or student portal before the exam session.', 5],
                ['Exam rules', 'What documents do I need for an exam?', 'Bring a valid student ID or another official identification document required by faculty rules.', 3],
            ],
            'Tuition' => [
                ['Tuition payment confirmation', 'How can I check whether my tuition payment was recorded?', 'You can check payment status through the student portal or ask Student Service to verify the payment.', 5],
                ['Tuition installments', 'Can I pay tuition in installments?', 'Tuition installment rules depend on the official faculty decision for the academic year.', 4],
                ['Payment instructions', 'Where can I find tuition payment instructions?', 'Payment instructions are available on the faculty website or from Student Service.', 4],
                ['Late tuition payment', 'What happens if I pay tuition late?', 'Late payment may affect student obligations, so contact Student Service as soon as possible.', 3],
                ['Tuition invoice', 'Can I get proof of tuition payment?', 'Yes, Student Service can confirm payment status or provide instructions for payment proof.', 3],
            ],
            'Student Service' => [
                ['Student certificate request', 'How do I request a student status certificate?', 'Submit a request to Student Service and include the purpose of the certificate.', 5],
                ['Change personal data', 'How can I update my personal data?', 'Contact Student Service with valid documentation for the requested data change.', 4],
                ['Student record book', 'Where can I get information about my student record?', 'Student Service provides information about records, enrollment status, and official documents.', 4],
                ['Document pickup', 'When can I pick up requested documents?', 'Document pickup depends on Student Service working hours and processing time.', 3],
                ['Enrollment verification', 'How can I verify my enrollment status?', 'You can verify enrollment status through the student portal or directly with Student Service.', 5],
            ],
            'Schedule' => [
                ['Class schedule changes', 'Where can I see changes in the class schedule?', 'Schedule changes are published on the faculty website, notice board, or official student portal.', 5],
                ['Consultation hours', 'Where can I find professor consultation hours?', 'Consultation hours are usually listed on the faculty website or course page.', 4],
                ['Classroom information', 'How do I know which classroom my class is in?', 'Classroom information is included in the official class schedule.', 4],
                ['Online classes', 'How will I know if a class is online?', 'Online class information is announced through Moodle, email, or the official schedule.', 3],
                ['Schedule conflicts', 'What should I do if two classes overlap?', 'Report schedule conflicts to Student Service or the relevant study program coordinator.', 3],
            ],
        ];

        foreach ($itemsByCategory as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->firstOrFail();

            foreach ($items as [$title, $question, $answer, $priority]) {
                KnowledgeItem::updateOrCreate(
                    ['title' => $title],
                    [
                        'category_id' => $category->id,
                        'question' => $question,
                        'answer' => $answer,
                        'is_active' => true,
                        'priority' => $priority,
                    ]
                );
            }
        }
    }
}
