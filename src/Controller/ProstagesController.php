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
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function afficherPageEntreprises(): Response
    {
        return $this->render('prostages/affichageEntreprises.html.twig');
    }
	
	/**
     * @Route("/formations", name="prostages_formations")
     */
    public function afficherPageFormations(): Response
    {
        return $this->render('prostages/affichageFormations.html.twig');
    }
	
	/**
     * @Route("/stage/{id}", name="prostages_stage")
     */
    public function afficherPageStage($id): Response
    {
        return $this->render('prostages/affichageStage.html.twig', [
            'idStage' => $id,
        ]);
    }
}
