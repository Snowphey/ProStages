<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;
use App\Form\EntrepriseType;
use App\Form\StageType;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(StageRepository $repositoryStages): Response
    {	
		$stages = $repositoryStages->findStagesEtEntreprises();
		
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
     * @Route("/stage/{idStage}", name="prostages_stage")
     */
    public function afficherPageStage(StageRepository $repositoryStages, $idStage): Response
    {	
        $stageSelectionne = $repositoryStages->findStageEntrepriseEtFormations($idStage);

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

    /**
     * @Route("/ajoutEntreprise", name="prostages_formulaireAjoutEntreprise")
     */
    public function ajouterEntreprise(Request $requeteHTTP, EntityManagerInterface $manager): Response
    {	
        // Création d'une entreprise initialement vierge
        $entreprise = new Entreprise();

        // Création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        // Récupération des données dans $entreprise si elles ont été soumises
        $formulaireEntreprise->handleRequest($requeteHTTP);

        // Traiter les données du formulaire s'il a été soumis et est valide
        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            // Enregistrer l'entreprise en BD
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des stages
            return $this->redirectToRoute('prostages_accueil');
        }

        // Afficher la page d'ajout d'une entreprise
        return $this->render('prostages/formulaireAjoutModifEntreprise.html.twig', 
        ['vueFormulaireEntreprise' => $formulaireEntreprise->createView (),
         'action' => 'ajouter']);
    }

    /**
     * @Route("/modificationEntreprise/{id}", name="prostages_formulaireModificationEntreprise")
     */
    public function modifierEntreprise(Request $requeteHTTP, EntityManagerInterface $manager, Entreprise $entreprise): Response
    {	
        // Création d'un objet formulaire pour modifier une entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        // Récupération des données dans $entreprise si elles ont été soumises
        $formulaireEntreprise->handleRequest($requeteHTTP);

        // Traiter les données du formulaire s'il a été soumis et est valide
        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            // Enregistrer l'entreprise en BD
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des stages
            return $this->redirectToRoute('prostages_accueil');
        }

        // Afficher la page d'ajout d'une entreprise
        return $this->render('prostages/formulaireAjoutModifEntreprise.html.twig', 
        ['vueFormulaireEntreprise' => $formulaireEntreprise->createView (),
         'action' => 'modifier']);
    }

    /**
     * @Route("/ajoutStage", name="prostages_formulaireAjoutStage")
     */
    public function ajouterStage(Request $requeteHTTP, EntityManagerInterface $manager): Response
    {	
        // Création d'un stage initialement vierge
        $stage = new Stage();

        // Création d'un objet formulaire pour ajouter un stage
        $formulaireStage = $this->createForm(StageType::class, $stage);

        // Récupération des données dans $stage si elles ont été soumises
        $formulaireStage->handleRequest($requeteHTTP);

        // Traiter les données du formulaire s'il a été soumis et est valide
        if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
        {
            // Enregistrer le stage en BD
            $manager->persist($stage);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des stages
            return $this->redirectToRoute('prostages_accueil');
        }

        // Afficher la page d'ajout d'un stage
        return $this->render('prostages/formulaireAjoutStage.html.twig', 
        ['vueFormulaireStage' => $formulaireStage->createView()]);
    }
}
