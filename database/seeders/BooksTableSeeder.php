<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Book; // Utilisation du modèle Book
use Faker\Factory as Faker;

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
        $faker = Faker::create();
        
        // Liste d'exemples pour rendre les données plus réalistes
        $bookTitles = [
            'Les Misérables', 'Don Quixote', '1984', 'Le Petit Prince',
            'Harry Potter et la pierre philosophale', 'Le Seigneur des Anneaux',
            'Chroniques martiennes', 'Guerre et Paix', 'L\'Étranger', 'Madame Bovary'
        ];
        
        $authors = [
            'Victor Hugo', 'Miguel de Cervantes', 'George Orwell', 'Antoine de Saint-Exupéry',
            'J.K. Rowling', 'J.R.R. Tolkien', 'Ray Bradbury', 'Léon Tolstoï',
            'Albert Camus', 'Gustave Flaubert'
        ];
        
        $editors = [
            'Gallimard', 'Flammarion', 'Hachette', 'Albin Michel',
            'Actes Sud', 'Grasset', 'Le Seuil', 'Pocket', 'Folio', 'Livre de Poche'
        ];
        
        $readingStatuses = ['read', 'to-read', 'pending'];
        
        for ($i = 1; $i <= 10; $i++) {              
            // Créer une entrée avec un mélange de données fixes et aléatoires
            Book::create([
                'cover_image' => '/images/cover_' . $i . '.png',
                'title' => $i <= 10 ? $bookTitles[$i-1] : 'Livre ' . $faker->sentence(rand(2, 5)),
                'sub_title' => $faker->sentence(),
                'author' => $i <= 10 ? $authors[$i-1] : $faker->name(),
                'reading_status' => $readingStatuses[array_rand($readingStatuses)],
                'number_of_pages' => rand(80, 1200),
                'release_date' => $this->randDate(),
                'editor' => $editors[array_rand($editors)],
                'isbn' => $faker->numerify('978#############'),
                'user_id' => rand(1, 2),
				'created_at' => $this->randDate(),
				'updated_at' => $this->randDate(),
            ]);
        }
    }
}