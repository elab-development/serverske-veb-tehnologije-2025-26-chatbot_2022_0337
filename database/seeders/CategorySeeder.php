<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Moodle' => 'Questions about Moodle access, courses, materials, and assignments.',
            'Exams' => 'Questions about exam registration, dates, results, and exam rules.',
            'Tuition' => 'Questions about tuition fees, payments, installments, and confirmations.',
            'Student Service' => 'Questions about certificates, documents, requests, and student records.',
            'Schedule' => 'Questions about classes, timetable changes, rooms, and consultations.',
        ];

        foreach ($categories as $name => $description) {
            Category::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }
    }
}
