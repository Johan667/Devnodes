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

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/modify', name: 'app_account_modify')]
    public function edit(Request $request)
    {
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
