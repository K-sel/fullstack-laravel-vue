<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Utilisation de la classe "Modèle" ;-)
use Faker\Factory as Faker;


class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void

	{
        $faker = Faker::create();
        

       
		for ($i = 1; $i <= 2; $i++) {
            $fullname = $faker->name();
            $firstname = explode(' ', $fullname)[0];
            $lastname = explode(' ', $fullname)[1];
			User::create([
				'firstname' => $firstname,
                'lastname' => $lastname,
				'email' =>  "$firstname.$lastname@seed.com",
				'password' => 'password' . $i,
				'admin' => rand(0, 1),
			]);
		}
	}
}