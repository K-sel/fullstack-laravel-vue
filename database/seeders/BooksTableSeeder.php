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

    public function run(): void
    {
        $books = [
            [
                'title' => 'Protocoles de Hubermann',
                'sub_title' => 'Guide des interventions scientifiques pour optimiser votre santé',
                'author' => 'Andrew Hubermann',
                'reading_status' => 'to-read',
                'resume' => 'Andrew Huberman, neuroscientifique reconnu, propose une série de protocoles pratiques fondés sur des recherches scientifiques pour améliorer la santé physique et mentale. Le livre couvre des thèmes essentiels tels que le sommeil réparateur, l’optimisation de la concentration, la réduction du stress et le renforcement de l’immunité. Chaque protocole est conçu pour être facilement intégré à la vie quotidienne, avec des recommandations précises sur la lumière, la respiration, la nutrition et l’exercice.',
                'format' => 'Broché',
                'number_of_pages' => 328,
                'release_date' => '2023-05-15',
                'editor' => 'Neuroscience Publications',
                'isbn' => '978-1234567890',
                'cover_image' => 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781668032145/protocols-9781668032145_hr.jpg',
            ],
            [
                'title' => 'Influence et manipulation',
                'sub_title' => 'Comprendre et contrer les techniques de manipulation',
                'author' => 'Robert Cialdini',
                'reading_status' => 'read',
                'resume' => 'Robert Cialdini explore dans cet ouvrage les six principes fondamentaux de l’influence : la réciprocité, l’engagement, la preuve sociale, l’autorité, l’affection et la rareté. Grâce à de nombreux exemples concrets, il démontre comment ces techniques sont utilisées dans la publicité, le marketing et même les relations quotidiennes. Ce livre donne les clés pour reconnaître et résister aux tentatives de manipulation auxquelles nous sommes exposés tous les jours.',
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
                'resume' => 'Dans cet ouvrage classique, Robert Greene présente 48 lois intemporelles sur l’art d’acquérir, conserver et utiliser le pouvoir. S’appuyant sur des exemples historiques et des anecdotes fascinantes, il dévoile les stratégies secrètes utilisées par les dirigeants, diplomates, généraux et rois à travers les âges. C’est un manuel amoral, voire cynique, destiné à ceux qui souhaitent comprendre les dynamiques subtiles du pouvoir et des relations humaines.',
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
                'resume' => 'Jordan Peterson, psychologue clinicien, propose douze principes pratiques pour mener une vie plus équilibrée et significative. À travers des anecdotes personnelles, des références culturelles et des analyses psychologiques, il encourage le lecteur à prendre ses responsabilités, à trouver du sens dans la souffrance et à ordonner son existence pour résister au chaos du monde moderne.',
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
                'resume' => 'Yuval Noah Harari retrace dans "Sapiens" l’histoire de l’humanité, depuis l’émergence de l’Homo sapiens jusqu’à l’ère moderne. En s’appuyant sur l’histoire, la biologie, l’anthropologie et l’économie, il explique comment les révolutions cognitive, agricole et scientifique ont façonné nos sociétés actuelles, nos croyances et nos comportements. Une réflexion passionnante sur ce qui nous rend humains.',
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
                'resume' => 'Dans un futur proche, un groupe de scientifiques développe "Nexus", une nanodrogue capable de connecter les esprits humains. Alors que les gouvernements et les entreprises cherchent à contrôler cette innovation révolutionnaire, des conflits éthiques et politiques éclatent. "Nexus" pose des questions profondes sur la liberté, l’identité et les dangers de la technologie lorsqu’elle fusionne directement avec l’esprit humain.',
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
                'resume' => 'Milly, une jeune femme au passé trouble, trouve un emploi comme femme de ménage pour la famille Winchester. Derrière la façade parfaite de cette famille aisée se cachent des secrets effrayants. Au fil du temps, Milly découvre que les apparences sont trompeuses et que sa propre vie est en danger. Un thriller psychologique haletant aux retournements de situation captivants.',
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
                'resume' => 'Peter Attia, médecin spécialisé en longévité, propose dans "Outlive" une approche innovante pour augmenter son espérance de vie en bonne santé. En combinant les dernières découvertes scientifiques sur la nutrition, l’exercice, la gestion du stress et la prévention des maladies chroniques, il donne aux lecteurs les outils pour vivre mieux et plus longtemps, en privilégiant la qualité de vie au simple prolongement biologique.',
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
                'resume' => 'David Goggins raconte dans ce livre son incroyable transformation : d’un jeune homme maltraité et obèse à un des soldats d’élite les plus endurcis. À travers ses expériences dans la Navy SEAL, les ultramarathons et les défis mentaux extrêmes, il expose la force du mental, l’importance de la résilience, et comment chacun peut repousser ses propres limites, peu importe les circonstances.',
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
                'resume' => 'Gary Keller explique comment la simplicité est la clé du succès. En se concentrant sur une seule chose importante à la fois, on maximise ses résultats et réduit le stress lié à la surcharge de tâches. Le livre propose une méthode efficace pour fixer ses priorités, éliminer les distractions et avancer avec clarté vers ses objectifs personnels et professionnels.',
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
                'resume' => 'Rédigé en grec au IIᵉ siècle, cet ouvrage rassemble les méditations personnelles de l’empereur romain Marc Aurèle. Avec une grande humilité, il y développe les principes du stoïcisme : acceptation des événements, discipline personnelle, et recherche constante du bien. "Pensées pour moi-même" est un guide intemporel sur la maîtrise de soi et la sagesse intérieure.',
                'format' => 'Poche',
                'number_of_pages' => 222,
                'release_date' => '2018-09-06',
                'editor' => 'Les Belles Lettres',
                'isbn' => '978-2251447094',
                'cover_image' => 'https://biblia.lesbelleslettres.com/data/cache/Product/front_cover_picture/big/6/9/2068.1646301483.jpg',
            ],
            [
                'title' => 'The Subtle Art of Not Giving a F*ck',
                'sub_title' => 'A Counterintuitive Approach to Living a Good Life',
                'author' => 'Mark Manson',
                'reading_status' => 'read',
                'resume' => 'Mark Manson rejette le positivisme forcé et propose une approche plus honnête de la vie : accepter nos limites, reconnaître nos échecs, et choisir consciemment ce qui mérite notre attention. En se basant sur son expérience personnelle et des concepts psychologiques solides, il propose un chemin vers une vie plus libre, plus authentique et moins stressée.',
                'format' => 'Broché',
                'number_of_pages' => 224,
                'release_date' => '2016-09-13',
                'editor' => 'HarperOne',
                'isbn' => '978-0062457714',
                'cover_image' => 'https://covers.openlibrary.org/b/id/14832143-L.jpg',
            ],
        ];
        
        foreach ($books as $bookData) {
            $createdAt = $this->randDate();
            $updatedAt = Carbon::parse($createdAt)->addDays(rand(0, 90));
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
                'user_id' => 1,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
