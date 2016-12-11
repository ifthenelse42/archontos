<?php

use Illuminate\Database\Seeder;

class BaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Création du premier compte, celui du Webmaster IFThenElse
		$pseudo = "IFThenElse";
		$password = bcrypt("admin"); // il devra le modifier immédiatement
		$secret_password = bcrypt("admin"); // ça aussi
		$email = '';

		$date = \Carbon\Carbon::now();

		$idAdmin = DB::table('utilisateurs')->insertGetId([
			'pseudo' => $pseudo,
			'email' => $email,
			'password' => $password,
			'level' => 4, // NIVEAU MAXIMUM - WEBMASTER
			'avatar' => '',
			'presentation' => '',
            'activity' => 1,
			'invisible' => 0,
			'anonymous' => 0,
			'ip' => '::1',
			'remember_token' => '',
			'created_at' => $date,
			'updated_at' => $date
		]);

		DB::table('admin')->insert([
			'utilisateurs_id' => $idAdmin,
			'secret_password' => $secret_password,
			'created_at' => $date,
			'updated_at' => $date
		]);

		// Création de la première catégorie
		$nomCategorie = "Développement";

		$idCategorie = DB::table('forum_categorie')->insertGetId([
			'nom' => $nomCategorie,
			'type' => 1,
			'created_at' => $date,
			'updated_at' => $date
		]);

		// Insertion des premiers forums dans la première catégorie
		$nbForum = 2; // le nombre de forum créé

		for($i = 0; $i < $nbForum; $i++)
		{
			$titre = "Forum #".$i;

			$description = "Description du forum #".$i;
			DB::table('forum')->insert([
				'categorie_id' => $idCategorie,
				'nom' => $titre,
				'description' => $description,
				'created_at' => $date,
				'updated_at' => $date,
			]);
		}

		// Création de la seconde catégorie
		$nomCategorie2 = "Discussions";

		$idCategorie2 = DB::table('forum_categorie')->insertGetId([
			'nom' => $nomCategorie2,
			'type' => 2,
			'created_at' => $date,
			'updated_at' => $date
		]);

		// Insertion des premiers forums dans la seconde catégorie
		$nbForum2 = 4; // le nombre de forum créé

		for($i2 = 0; $i2 < $nbForum2; $i2++)
		{
			$titre2 = "Forum #".$i2;

			$description2 = "Description du forum #".$i2;
			DB::table('forum')->insert([
				'categorie_id' => $idCategorie2,
				'nom' => $titre2,
				'description' => $description2,
				'created_at' => $date,
				'updated_at' => $date,
			]);
		}
    }
}
