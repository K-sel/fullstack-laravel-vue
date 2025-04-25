<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Book;

class BooksTableSeeder extends Seeder
{
    private function randDate()
    {
        $nbJours = rand(-3650, 0); // Plage de dates sur environ 10 ans
        return Carbon::now()->addDays($nbJours);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        
        $books = [
            [
                'title' => 'Protocoles de Hubermann',
                'sub_title' => 'Guide des interventions scientifiques pour optimiser votre santé',
                'author' => 'Andrew Hubermann',
                'reading_status' => 'to-read',
                'resume' => 'Collection de protocoles basés sur la neuroscience pour améliorer la santé, le sommeil, la concentration et la vitalité.',
                'format' => 'Broché',
                'number_of_pages' => 328,
                'release_date' => '2023-05-15',
                'editor' => 'Neuroscience Publications',
                'isbn' => '978-1234567890',
                'cover_image' => 'https://example.com/hubermann.jpg',
            ],
            [
                'title' => 'Influence et manipulation',
                'sub_title' => 'Comprendre et contrer les techniques de manipulation',
                'author' => 'Robert Cialdini',
                'reading_status' => 'read',
                'resume' => 'Analyse des six principes psychologiques qui dirigent le comportement humain et comment ils sont utilisés en persuasion et marketing.',
                'format' => 'Poche',
                'number_of_pages' => 318,
                'release_date' => '2004-09-02',
                'editor' => 'First Editions',
                'isbn' => '978-2876914834',
                'cover_image' => 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/67/9b/56/5675879/1507-1/tsp20250325121952/Influence-et-manipulation.jpg',
            ],
            [
                'title' => 'Power',
                'sub_title' => 'Les 48 lois du pouvoir',
                'author' => 'Robert Greene',
                'reading_status' => 'pending',
                'resume' => 'Guide amoral sur l\'acquisition du pouvoir, inspiré de 3000 ans d\'histoire des stratégies de pouvoir.',
                'format' => 'Relié',
                'number_of_pages' => 496,
                'release_date' => '2009-11-03',
                'editor' => 'Viking Press',
                'isbn' => '978-0140280197',
                'cover_image' => 'https://m.media-amazon.com/images/I/611X8GI7hpL.jpg',
            ],
            [
                'title' => '12 règles pour une vie',
                'sub_title' => 'Un antidote au chaos',
                'author' => 'Jordan B. Peterson',
                'reading_status' => 'to-read',
                'resume' => 'Un guide pratique sur les principes éthiques pour une vie équilibrée et significative dans un monde complexe.',
                'format' => 'Broché',
                'number_of_pages' => 448,
                'release_date' => '2018-01-23',
                'editor' => 'Random House Canada',
                'isbn' => '978-0345816023',
                'cover_image' => 'https://m.media-amazon.com/images/I/71OVB8HknWL.jpg',
            ],
            [
                'title' => 'Sapiens',
                'sub_title' => 'Une brève histoire de l\'humanité',
                'author' => 'Yuval Noah Harari',
                'reading_status' => 'read',
                'resume' => 'Histoire de l\'évolution humaine, de l\'âge de pierre jusqu\'aux révolutions technologiques du 21e siècle.',
                'format' => 'Broché',
                'number_of_pages' => 512,
                'release_date' => '2015-05-01',
                'editor' => 'Albin Michel',
                'isbn' => '978-2226257017',
                'cover_image' => 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/48/79/6c/7108936/1507-1/tsp20250127075013/Sapiens-edition-2022.jpg',
            ],
            [
                'title' => 'Nexus',
                'sub_title' => 'Un thriller de science-fiction',
                'author' => 'Ramez Naam',
                'reading_status' => 'pending',
                'resume' => 'Dans un futur proche, une drogue expérimentale permet de connecter les esprits humains directement les uns aux autres.',
                'format' => 'Poche',
                'number_of_pages' => 528,
                'release_date' => '2013-06-13',
                'editor' => 'Angry Robot',
                'isbn' => '978-0857662934',
                'cover_image' => 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/ac/2f/13/18034604/1507-1/tsp20241203083943/Nexus-version-francaise-Meilleur-eai-2024-Lire-Magazine.jpg',
            ],
            [
                'title' => 'La femme de ménage',
                'sub_title' => 'Une histoire troublante',
                'author' => 'Freida McFadden',
                'reading_status' => 'to-read',
                'resume' => 'Un thriller psychologique sur une femme de ménage qui découvre les secrets sombres de la famille pour laquelle elle travaille.',
                'format' => 'Poche',
                'number_of_pages' => 384,
                'release_date' => '2022-04-26',
                'editor' => 'Milady',
                'isbn' => '978-2290391174',
                'cover_image' => 'https://images.epagine.fr/174/9782290391174_1_75.jpg',
            ],
            [
                'title' => 'Outlive',
                'sub_title' => 'La science et l\'art de la longévité',
                'author' => 'Peter Attia',
                'reading_status' => 'read',
                'resume' => 'Guide médical complet sur l\'extension de la durée de vie en bonne santé, basé sur les dernières recherches scientifiques.',
                'format' => 'Relié',
                'number_of_pages' => 496,
                'release_date' => '2023-03-28',
                'editor' => 'Harmony Books',
                'isbn' => '978-0593236598',
                'cover_image' => 'https://m.media-amazon.com/images/I/41w+zyAK8NL._SL500_.jpg',
            ],
            [
                'title' => 'Can\'t Hurt Me',
                'sub_title' => 'Master Your Mind and Defy the Odds',
                'author' => 'David Goggins',
                'reading_status' => 'read',
                'resume' => 'Mémoires d\'un ancien Navy SEAL sur le dépassement des limites personnelles et la force mentale.',
                'format' => 'Broché',
                'number_of_pages' => 364,
                'release_date' => '2018-12-04',
                'editor' => 'Lioncrest Publishing',
                'isbn' => '978-1544512273',
                'cover_image' => 'https://cdn.kobo.com/book-images/80916399-e514-45a4-b63f-983a9a2aaa78/1200/1200/False/can-t-hurt-me.jpg',
            ],
            [
                'title' => 'The One Thing',
                'sub_title' => 'Passez à l\'essentiel',
                'author' => 'Gary Keller',
                'reading_status' => 'to-read',
                'resume' => 'Guide pour se concentrer sur l\'essentiel et éliminer les distractions pour atteindre ses objectifs.',
                'format' => 'Broché',
                'number_of_pages' => 240,
                'release_date' => '2014-04-01',
                'editor' => 'Belfond',
                'isbn' => '978-2714459329',
                'cover_image' => 'https://cdn.kobo.com/book-images/ae538d49-2dc7-42a2-8b3e-907ee3495747/1200/1200/False/the-one-thing-passez-a-l-essentiel-1.jpg',
            ],
            [
                'title' => 'Pensées pour moi-même',
                'sub_title' => 'Le livre de sagesse de l\'empereur philosophe',
                'author' => 'Marc Aurèle',
                'reading_status' => 'pending',
                'resume' => 'Recueil de réflexions personnelles sur la philosophie stoïcienne par l\'empereur romain Marc Aurèle.',
                'format' => 'Poche',
                'number_of_pages' => 222,
                'release_date' => '2018-09-06', // Date approximative de l'édition moderne
                'editor' => 'Les Belles Lettres',
                'isbn' => '978-2251447094',
                'cover_image' => 'https://biblia.lesbelleslettres.com/data/cache/Product/front_cover_picture/big/6/9/2068.1646301483.jpg',
            ],
            [
                'title' => 'The Subtle Art of Not Giving a F*ck',
                'sub_title' => 'A Counterintuitive Approach to Living a Good Life',
                'author' => 'Mark Manson',
                'reading_status' => 'read',
                'resume' => 'Guide anti-développement personnel qui prône l\'acceptation des limites et l\'importance de choisir ce qui compte vraiment.',
                'format' => 'Broché',
                'number_of_pages' => 224, 
                'release_date' => '2016-09-13',
                'editor' => 'HarperOne',
                'isbn' => '978-0062457714',
                'cover_image' => 'https://covers.openlibrary.org/b/id/14832143-L.jpg',
            ],
        ];
        
        foreach ($books as $bookData) {
            // Génération de dates aléatoires pour created_at et updated_at
            $createdAt = $this->randDate();  
            $updatedAt = Carbon::parse($createdAt)->addDays(rand(0, 90)); // La mise à jour intervient entre 0 et 90 jours après la création
            
            // Conversion de la date de publication au format Carbon
            $releaseDate = Carbon::parse($bookData['release_date']);
            
            Book::create([
                'title' => $bookData['title'],
                'sub_title' => $bookData['sub_title'],
                'author' => $bookData['author'],
                'reading_status' => $bookData['reading_status'],
                'resume' => $bookData['resume'],
                'format' => $bookData['format'],
                'number_of_pages' => $bookData['number_of_pages'],
                'release_date' => $releaseDate,
                'editor' => $bookData['editor'],
                'isbn' => $bookData['isbn'],
                'cover_image' => $bookData['cover_image'],
                'user_id' => rand(1, 2), // Attribution aléatoire à l'un des deux utilisateurs
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}