<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Form\EditAccountType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    private $entityManager;

    // définit le constructeur d'une classe qui utilise l'injection de dépendances pour recevoir un service en paramètre
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        // Renvoie vers la page "compte"

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/modify', name: 'app_account_modify')]
    public function edit(Request $request)
    {
        // Crée un formulaire pour modifier les informations d'un utilisateur connecté,
        // gère la soumission de ce formulaire et met à jour les données de l'utilisateur enregistrées dans la base de données.
        // Enfin, il renvoie une réponse HTTP sous forme d'une vue Twig.

        $user = $this->getUser();
        $form = $this->createForm(EditAccountType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des données soumises
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this -> addFlash ("message", "Informations modifié avec succès.");
            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/password/change', name: 'change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // Permet de gérer la modification du mot de passe d'un utilisateur connecté.
        // Il crée un formulaire à partir de la classe ChangePasswordType, gère la soumission de ce formulaire
        // et met à jour le mot de passe de l'utilisateur dans la base de données si les données soumises sont valides.
        // Enfin, il renvoie une réponse HTTP sous forme d'une redirection vers une autre page.

        $change = $this->createForm(ChangePasswordType::class);

        $change->handleRequest($request);
        if ($change->isSubmitted() && $change->isValid()) {
            $user = $this->getUser();
            $oldPass = $change->get('password')->getData();
            $newPass = $change->get('newPassword')->getData();

            if (password_verify($oldPass, $user->getPassword())) {
                $user->setPassword( $userPasswordHasher->hashPassword($user, $newPass) );
                $this->entityManager->flush();
                $this -> addFlash ("message", "Mot de passe modifié avec succès.");
                return $this->redirectToRoute("app_account");
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $change->createView()
        ]);
    }


    #[Route('/account/delete', name: 'delete_account')]
    public function deleteAccount()
    {
        $user = $this->getUser();

        $newSession = new Session();
        $newSession->invalidate();

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        $this -> addFlash ("message", "Compte supprimé avec succès.");

        return $this->redirectToRoute('app_home');
    }


}
