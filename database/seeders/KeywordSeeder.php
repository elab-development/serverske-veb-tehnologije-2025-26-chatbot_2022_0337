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
            'Problem sa prijavom na Moodle' => ['moodle', 'prijava', 'pristup', 'lozinka', 'nalog'],
            'Kurs nije vidljiv na Moodle-u' => ['moodle', 'kurs', 'predmet', 'nastavnik', 'vidljiv'],
            'Predaja zadatka na Moodle-u' => ['zadatak', 'predaja', 'upload', 'rok', 'moodle'],
            'Resetovanje Moodle lozinke' => ['lozinka', 'resetovanje', 'moodle', 'nalog'],
            'Materijali za nastavu na Moodle-u' => ['materijali', 'predavanja', 'nastava', 'moodle'],
            'Rok za prijavu ispita' => ['ispit', 'prijava', 'rok', 'ispitni-rok'],
            'Odjava ispita' => ['ispit', 'odjava', 'prijava', 'rok'],
            'Rezultati ispita' => ['rezultati', 'ocjena', 'ispit', 'portal'],
            'Raspored ispita' => ['ispit', 'raspored', 'termin', 'datum'],
            'Pravila za polaganje ispita' => ['ispit', 'pravila', 'indeks', 'dokument'],
            'Zahtjev za potvrdu o studiranju' => ['potvrda', 'zahtjev', 'studentska-sluzba', 'status'],
            'Promjena ličnih podataka' => ['licni-podaci', 'promjena', 'dokumenti', 'studentska-sluzba'],
            'Studentska evidencija' => ['evidencija', 'dosije', 'status', 'dokumenti'],
            'Preuzimanje dokumenata' => ['dokumenti', 'preuzimanje', 'radno-vrijeme', 'studentska-sluzba'],
            'Provjera statusa studenta' => ['status', 'student', 'provjera', 'portal'],
            'Provjera uplate školarine' => ['skolarina', 'uplata', 'provjera', 'portal'],
            'Plaćanje školarine u ratama' => ['skolarina', 'rate', 'placanje', 'uplata'],
            'Instrukcije za uplatu školarine' => ['uplata', 'instrukcije', 'skolarina', 'racun'],
            'Kašnjenje sa uplatom školarine' => ['kasnjenje', 'uplata', 'skolarina', 'obaveze'],
            'Potvrda o plaćenoj školarini' => ['potvrda', 'placanje', 'uplata', 'skolarina'],
            'Izmjene rasporeda nastave' => ['raspored', 'izmjene', 'nastava', 'portal'],
            'Termini konsultacija' => ['konsultacije', 'profesor', 'termin', 'predmet'],
            'Informacije o učionici' => ['ucionica', 'sala', 'raspored', 'nastava'],
            'Online nastava' => ['online', 'nastava', 'moodle', 'email'],
            'Preklapanje termina nastave' => ['raspored', 'preklapanje', 'termini', 'koordinator'],
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
