<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\UserType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {

    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        //Créer un utilisateur vide
        $utilisateur = new User();

        // Création du formulaire permettant de saisir un utilisateur
        $formulaireUtilisateur = $this->createForm(UserType::class, $utilisateur);

        /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
        dans cette requête contient des variables nom, prenom, etc. alors la méthode handleRequest()
        récupère les valeurs de ces variables et les affecte à l'objet $utilisateur*/
        $formulaireUtilisateur->handleRequest($request);

         if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
         {
            // Attribuer un rôle à l'utilisateur
            $utilisateur->setRoles(['ROLE_USER']);

            //Encoder le mot de passe de l'utilisateur
            $encodagePassword = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($encodagePassword);

            // Enregistrer l'utilisateur en base de données
            $manager->persist($utilisateur);
            $manager->flush();

            // Rediriger l'utilisateur vers la page de login
            return $this->redirectToRoute('app_login');
         }

        // Afficher la page présentant le formulaire d'inscription
        return $this->render('security/inscription.html.twig',['vueFormulaireInscription' => $formulaireUtilisateur->createView()]);
    }
}
