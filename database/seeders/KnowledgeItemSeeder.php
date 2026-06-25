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
                ['Problem sa prijavom na Moodle', 'Šta da uradim ako ne mogu da se prijavim na Moodle?', 'Prvo provjerite korisničko ime i lozinku za studentski nalog. Ako problem i dalje postoji, resetujte lozinku ili se obratite Studentskoj službi.', 5],
                ['Kurs nije vidljiv na Moodle-u', 'Zašto ne vidim jedan od svojih kurseva na Moodle-u?', 'Kurs može biti sakriven dok ga predmetni nastavnik ne aktivira. Ako kurs treba da bude dostupan, obratite se nastavniku ili Studentskoj službi.', 4],
                ['Predaja zadatka na Moodle-u', 'Kako da predam zadatak preko Moodle-a?', 'Otvorite stranicu predmeta, izaberite aktivnost za predaju zadatka, postavite traženi fajl i potvrdite predaju prije isteka roka.', 4],
                ['Resetovanje Moodle lozinke', 'Kako mogu da resetujem lozinku za Moodle?', 'Koristite opciju za resetovanje lozinke povezanu sa studentskim nalogom ili zatražite pomoć od Studentske službe.', 3],
                ['Materijali za nastavu na Moodle-u', 'Gdje mogu da pronađem materijale za predavanja na Moodle-u?', 'Materijali su obično dostupni u okviru stranice predmeta nakon što ih nastavnik postavi.', 3],
            ],
            'Ispiti' => [
                ['Rok za prijavu ispita', 'Kada mogu da prijavim ispit?', 'Ispit se prijavljuje u zvaničnom roku za prijavu koji se objavljuje prije svakog ispitnog roka.', 5],
                ['Odjava ispita', 'Da li mogu da odjavim prijavljeni ispit?', 'Ispit se najčešće može odjaviti preko studentskog portala do roka koji je predviđen za odjavu.', 4],
                ['Rezultati ispita', 'Gdje mogu da vidim rezultate ispita?', 'Rezultati ispita se objavljuju na studentskom portalu, na Moodle-u ili ih objavljuje predmetni nastavnik.', 4],
                ['Raspored ispita', 'Gdje mogu da pronađem raspored ispita?', 'Raspored ispita se objavljuje na sajtu fakulteta ili studentskom portalu prije početka ispitnog roka.', 5],
                ['Pravila za polaganje ispita', 'Koja dokumenta su mi potrebna za izlazak na ispit?', 'Na ispit ponesite indeks ili drugi važeći identifikacioni dokument koji je propisan pravilima fakulteta.', 3],
            ],
            'Studentska služba' => [
                ['Zahtjev za potvrdu o studiranju', 'Kako mogu da dobijem potvrdu o studiranju?', 'Potrebno je da podnesete zahtjev Studentskoj službi i navedete svrhu za koju vam je potvrda potrebna.', 5],
                ['Promjena ličnih podataka', 'Kako mogu da promijenim lične podatke u evidenciji?', 'Obratite se Studentskoj službi i dostavite važeću dokumentaciju kojom se potvrđuje tražena promjena.', 4],
                ['Studentska evidencija', 'Gdje mogu da dobijem informacije o svom studentskom dosijeu?', 'Studentska služba daje informacije o evidenciji, statusu studenta, upisu i službenim dokumentima.', 4],
                ['Preuzimanje dokumenata', 'Kada mogu da preuzmem tražena dokumenta?', 'Preuzimanje dokumenata zavisi od radnog vremena Studentske službe i vremena potrebnog za obradu zahtjeva.', 3],
                ['Provjera statusa studenta', 'Kako mogu da provjerim svoj status studenta?', 'Status studenta možete provjeriti preko studentskog portala ili direktno u Studentskoj službi.', 5],
            ],
            'Školarina' => [
                ['Provjera uplate školarine', 'Kako mogu da provjerim da li je uplata školarine evidentirana?', 'Status uplate možete provjeriti preko studentskog portala ili zatražiti provjeru od Studentske službe.', 5],
                ['Plaćanje školarine u ratama', 'Da li školarinu mogu da platim u ratama?', 'Mogućnost plaćanja u ratama zavisi od zvanične odluke fakulteta za tekuću akademsku godinu.', 4],
                ['Instrukcije za uplatu školarine', 'Gdje mogu da pronađem instrukcije za uplatu školarine?', 'Instrukcije za uplatu dostupne su na sajtu fakulteta ili ih možete dobiti u Studentskoj službi.', 4],
                ['Kašnjenje sa uplatom školarine', 'Šta se dešava ako zakasnim sa uplatom školarine?', 'Kašnjenje može uticati na studentske obaveze, zato je potrebno da se što prije obratite Studentskoj službi.', 3],
                ['Potvrda o plaćenoj školarini', 'Da li mogu da dobijem potvrdu o plaćenoj školarini?', 'Da. Studentska služba može potvrditi status uplate ili dati uputstvo za dobijanje potvrde o plaćanju.', 3],
            ],
            'Raspored' => [
                ['Izmjene rasporeda nastave', 'Gdje mogu da vidim izmjene rasporeda nastave?', 'Izmjene rasporeda objavljuju se na sajtu fakulteta, oglasnoj tabli ili zvaničnom studentskom portalu.', 5],
                ['Termini konsultacija', 'Gdje mogu da pronađem termine konsultacija kod profesora?', 'Termini konsultacija se najčešće nalaze na sajtu fakulteta ili na stranici predmeta.', 4],
                ['Informacije o učionici', 'Kako da znam u kojoj učionici imam nastavu?', 'Informacija o učionici nalazi se u zvaničnom rasporedu nastave.', 4],
                ['Online nastava', 'Kako ću znati da li se nastava održava online?', 'Informacije o online nastavi objavljuju se preko Moodle-a, elektronske pošte ili zvaničnog rasporeda.', 3],
                ['Preklapanje termina nastave', 'Šta da uradim ako mi se preklapaju termini nastave?', 'Preklapanje termina prijavite Studentskoj službi ili koordinatoru odgovarajućeg studijskog programa.', 3],
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
