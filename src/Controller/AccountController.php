<?php

namespace App\Controller;


use App\Entity\User;
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
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
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
            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/password', name: 'app_account_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);


            $this->entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
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

        return $this->redirectToRoute('app_home');
    }


}
