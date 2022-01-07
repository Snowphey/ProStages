<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		// Création d'un générateur de données Faker
		$faker = \Faker\Factory::create('fr_FR');
		
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
			$manager->persist($formation);
		}
		
		$nombreEntreprises = $faker->numberBetween(30,40);
		
		for ($i = 1 ; $i <= $nombreEntreprises ; $i++)
		{
			$entreprise = new Entreprise();
			$entreprise->setNom($faker->company());
			$entreprise->setActivite($faker->realText(50,2));
			$entreprise->setAdresse($faker->address());
			$entreprise->setURLsite($faker->domainName());
			
			$nombreStages = $faker->numberBetween(1,3);
			
			for ($j = 1 ; $j <= $nombreStages ; $j++)
			{
				$stage = new Stage();
				$stage->setTitre($faker->jobTitle());
				$stage->setDescMissions($faker->realText(255,2));
				$stage->setEmailContact($faker->email());
				$stage->setEntreprise($entreprise);
				
				$nombreFormations = $faker->numberBetween(1,3);
				
				for ($k = 1 ; $k <= $nombreFormations ; $k++)
				{
					$indiceFormation = $faker->unique()->numberBetween(0,3);	// On prend un indice unique parmi ceux 
																				// du tableau de formations (avec 4 entrées)
					$stage->addFormation($tableauFormations[$indiceFormation]);
				}
				
				$faker->unique($reset = true);
				
				$manager->persist($stage);
			}
			
			$manager->persist($entreprise);
		}
		
        $manager->flush();
    }
}
