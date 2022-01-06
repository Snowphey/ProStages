<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(): Response
    {
		$repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
		
		$stages = $repositoryStages->findAll();
		
        return $this->render('prostages/index.html.twig', ['stages' => $stages]);
    }
	
	/**
     * @Route("/formations", name="prostages_formations")
     */
    public function afficherPageFormations(): Response
    {
		$repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);
		
		$formations = $repositoryFormations->findAll();
		
        return $this->render('prostages/affichageFormations.html.twig', ['formations' => $formations]);
    }
	
	/**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function afficherPageEntreprises(): Response
    {
		$repositoryEntreprises = $this->getDoctrine()->getRepository(Entreprise::class);
		
		$entreprises = $repositoryEntreprises->findAll();
		
        return $this->render('prostages/affichageEntreprises.html.twig', ['entreprises' => $entreprises]);
    }
	
	/**
     * @Route("/stage/{idStage}", name="prostages_stage")
     */
    public function afficherPageStage($idStage): Response
    {
		$repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
		
		$stageSelectionne = $repositoryStages->find($idStage);
		
        return $this->render('prostages/affichageStage.html.twig', ['stage' => $stageSelectionne]);
    }
	
	/**
     * @Route("/formations/{idFormation}", name="prostages_listeStages_formation")
     */
    public function afficherListeStagesFormation($idFormation): Response
    {
		$repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);
		
		$formationSelectionnee = $repositoryFormations->find($idFormation);
		
        return $this->render('prostages/affichageListeStagesFormation.html.twig', ['formation' => $formationSelectionnee]);
    }
	
	/**
     * @Route("/entreprises/{idEntreprise}", name="prostages_listeStages_entreprise")
     */
    public function afficherListeStagesEntreprise($idEntreprise): Response
    {
		$repositoryEntreprises = $this->getDoctrine()->getRepository(Entreprise::class);
		
		$entrepriseSelectionnee = $repositoryEntreprises->find($idEntreprise);
		
        return $this->render('prostages/affichageListeStagesEntreprise.html.twig', ['entreprise' => $entrepriseSelectionnee]);
    }
}
