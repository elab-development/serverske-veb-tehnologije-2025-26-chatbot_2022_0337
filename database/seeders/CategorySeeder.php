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
            'Moodle' => 'Pitanja o pristupu Moodle platformi, kursevima, materijalima i zadacima.',
            'Ispiti' => 'Pitanja o prijavi ispita, terminima, rezultatima i pravilima polaganja.',
            'Studentska služba' => 'Pitanja o potvrdama, dokumentima, zahtjevima i studentskoj evidenciji.',
            'Školarina' => 'Pitanja o školarini, uplatama, ratama i potvrdama o plaćanju.',
            'Raspored' => 'Pitanja o rasporedu nastave, izmjenama termina, učionicama i konsultacijama.',
        ];

        foreach ($categories as $name => $description) {
            Category::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }
    }
}
