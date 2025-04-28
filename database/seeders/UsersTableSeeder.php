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
		User::create([
			'firstname' => 'john',
			'lastname' => 'doe',
			'email' =>  "johndoe@seed.com",
			'password' => 'password1',
			'admin' => 1,
		]);
	}
}
