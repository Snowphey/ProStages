<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		// Création d'un générateur de données Faker
		$faker = \Faker\Factory::create('fr_FR');
		
		// Création de 4 formations à la main
        $dutInfo = new Formation();
		$dutInfo->setNomLong("Diplôme Universitaire de Technologie en Informatique");
		$dutInfo->setNomCourt("DUT Informatique");
		
		$dutGea = new Formation();
		$dutGea->setNomLong("Diplôme Universitaire de Technologie en Gestion des Entreprises et des Administrations");
		$dutGea->setNomCourt("DUT GEA");
		
		$LPprog = new Formation();
		$LPprog->setNomLong("Licence Professionnelle Programmation Avancée");
		$LPprog->setNomCourt("LP Prog Avancée");
		
		$LPnum = new Formation();
		$LPnum->setNomLong("Licence Professionnelle Métiers du Numérique");
		$LPnum->setNomCourt("LP Métiers du Numérique");
		
		$tableauFormations = array($dutInfo, $dutGea, $LPprog, $LPnum);
		
		foreach($tableauFormations as $formation)
		{
			// On persiste chaque formation créée
			$manager->persist($formation);
		}
		
		// On génère entre 30 et 40 entreprises
		$nombreEntreprises = $faker->numberBetween(30,40);
		
		for ($i = 1 ; $i <= $nombreEntreprises ; $i++)
		{
			$entreprise = new Entreprise();
			$entreprise->setNom($faker->company());
			$entreprise->setActivite($faker->realText(50,2));
			$entreprise->setAdresse($faker->address());
			$entreprise->setURLsite($faker->domainName());
			
			// Chaque entreprise aura entre 1 et 3 stages associés
			$nombreStages = $faker->numberBetween(1,3);
			
			for ($j = 1 ; $j <= $nombreStages ; $j++)
			{
				$stage = new Stage();
				$stage->setTitre($faker->jobTitle());
				$stage->setDescMissions($faker->realText(255,2));
				$stage->setEmailContact($faker->email());
				$stage->setEntreprise($entreprise);	// Le stage créé sera associé à l'entreprise qu'on est en train de créer
				
				// Chaque stage aura entre 1 et 3 formations associées
				$nombreFormations = $faker->numberBetween(1,3);
				
				for ($k = 1 ; $k <= $nombreFormations ; $k++)
				{
					// On prend un indice unique parmi ceux du tableau de formations (avec 4 entrées)
					// afin de ne pas avoir un stage associé plusieurs fois à la même formation
					$indiceFormation = $faker->unique()->numberBetween(0,3);	
					$stage->addFormation($tableauFormations[$indiceFormation]);
				}
				
				// On réinitialise la fonction unique pour le prochain stage
				$faker->unique($reset = true);
				
				// On persiste le stage créé
				$manager->persist($stage);
			}

			// On persiste l'entreprise créée
			$manager->persist($entreprise);
		}

		// On crée deux utilisateurs
		$utilisateur = new User();
		$utilisateur->setPrenom("Sophie");
		$utilisateur->setNom("Longy");
		$utilisateur->setUsername("slongy");
		$utilisateur->setPassword('$2y$10$Wuw8tKPHXqdVXNeR2mXg4u3ULMau/yXOyD5ejUtCuQdrtgjD4TOiC');
		$utilisateur->setRoles(['ROLE_ADMIN']);

		$manager->persist($utilisateur);

		$utilisateur = new User();
		$utilisateur->setPrenom("Maya");
		$utilisateur->setNom("Fey");
		$utilisateur->setUsername("mfey");
		$utilisateur->setPassword('$2y$10$5gincQF7b.waHMrT8Sv6OO6KXCGrYOqD/H09JZDDAKTjyXIHRfTU2');
		$utilisateur->setRoles(['ROLE_USER']);

		$manager->persist($utilisateur);

		// On valide tous les changements
		
        $manager->flush();
    }
}
