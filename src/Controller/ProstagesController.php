<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(StageRepository $repositoryStages): Response
    {	
		$stages = $repositoryStages->findAll();
		
        return $this->render('prostages/index.html.twig', ['stages' => $stages]);
    }
	
	/**
     * @Route("/formations", name="prostages_formations")
     */
    public function afficherPageFormations(FormationRepository $repositoryFormations): Response
    {	
		$formations = $repositoryFormations->findAll();
		
        return $this->render('prostages/affichageFormations.html.twig', ['formations' => $formations]);
    }
	
	/**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function afficherPageEntreprises(EntrepriseRepository $repositoryEntreprises): Response
    {	
		$entreprises = $repositoryEntreprises->findAll();
		
        return $this->render('prostages/affichageEntreprises.html.twig', ['entreprises' => $entreprises]);
    }
	
	/**
     * @Route("/stage/{id}", name="prostages_stage")
     */
    public function afficherPageStage(Stage $stageSelectionne): Response
    {	
        return $this->render('prostages/affichageStage.html.twig', ['stage' => $stageSelectionne]);
    }
	
	/**
     * @Route("/formations/{nomCourtFormation}", name="prostages_listeStages_formation_nomCourt")
     */
    public function afficherListeStagesParNomCourtFormation(StageRepository $repositoryStages, $nomCourtFormation): Response
    {	
        $stages = $repositoryStages->findStagesParNomCourtFormation($nomCourtFormation);

        return $this->render('prostages/affichageListeStagesFormation.html.twig', ['stages' => $stages,
                                                                                   'nomCourtFormation' => $nomCourtFormation]);
    }

    /**
     * @Route("/entreprises/{nomEntreprise}", name="prostages_listeStages_entreprise_nom")
     */
    public function afficherListeStagesParNomEntreprise(StageRepository $repositoryStages, $nomEntreprise): Response
    {
        $stages = $repositoryStages->findStagesParNomEntreprise($nomEntreprise);

        return $this->render('prostages/affichageListeStagesEntreprise.html.twig', ['stages' => $stages,
                                                                                    'nomEntreprise' => $nomEntreprise]);
    }
}
