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
		
        $formation = new Formation();
		$formation->setCode("1");
		$formation->setNomLong("Diplôme Universitaire de Technologie en Informatique");
		$formation->setNomCourt("DUT Informatique");
		$manager->persist($formation);
		
		$formation = new Formation();
		$formation->setCode("2");
		$formation->setNomLong("Diplôme Universitaire de Technologie en Gestion des Entreprises et des Administrations");
		$formation->setNomCourt("DUT GEA");
		$manager->persist($formation);
		
		$formation = new Formation();
		$formation->setCode("3");
		$formation->setNomLong("Licence Professionnelle Programmation Avancée");
		$formation->setNomCourt("LP Prog Avancée");
		$manager->persist($formation);
		
		$formation = new Formation();
		$formation->setCode("4");
		$formation->setNomLong("Licence Professionnelle Métiers du Numérique");
		$formation->setNomCourt("LP Métiers du Numérique");
		$manager->persist($formation);

        $manager->flush();
    }
}
