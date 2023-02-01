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
            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/modify.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/password', name: 'app_account_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $modifPassword = $this->createForm(ChangePasswordType::class);

        $modifPassword->handleRequest($request);

        if ($modifPassword->isSubmitted() && $modifPassword->isValid()) {
            $old_pwd = $modifPassword->get('old_password')->getData();
            // On veux verifier ici que l'ancien mot de passe coresspond à celui de la bdd.
            if ($encoder->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $modifPassword->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $this->entityManager->flush($password);
                $notification = 'Votre mot de passe à bien été mise à jours';
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $modifPassword->createView()
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
