<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function afficherPageAccueil(): Response
    {
        return $this->render('prostages/affichageAccueil.html.twig');
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
     * @Route("/stages/{id}", name="prostages_stages")
     */
    public function afficherPageStages($id): Response
    {
        return $this->render('prostages/affichageStages.html.twig', [
            'idStage' => $id,
        ]);
    }
}
