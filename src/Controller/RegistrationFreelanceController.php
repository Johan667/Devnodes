<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Form\RegistrationFreelanceType;
use App\Repository\FreelanceRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFreelanceController extends AbstractController
{
    #[Route('/register/freelance', name: 'app_register_freelance')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager, VerifyEmailHelperInterface $verifyEmailHelper): Response
    {
        $freelance = new Freelance();
        $form = $this->createForm(RegistrationFreelanceType::class, $freelance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $freelance->setRoles(["ROLE_FREELANCE"]);
            $email = $form->get('email')->getData();
            $freelance->setEmail($email);

            // encode the plain password
            $freelance->setPassword(
                $userPasswordHasher->hashPassword(
                    $freelance,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($freelance);
            $entityManager->flush();

            $signatureComponents = $verifyEmailHelper->generateSignature('app_verify_email', $freelance->getId(), $freelance->getEmail());
            $signedUrl = $this->generateUrl('app_verify_email', $signatureComponents, true);

            $email = (new TemplatedEmail())
                ->from('devnodes.contact@gmail.com')
                ->to($freelance->getEmail())
                ->subject('Veuillez confirmer votre adresse e-mail')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context([
                    'signedUrl' => $signedUrl,
                ]);

            $mailer->send($email);

            $userAuthenticator->authenticateUser(
                $freelance,
                $authenticator,
                $request
            );

            $this->addFlash('success', 'Votre inscription a été réussie. Veuillez confirmer votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration_freelance/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, FreelanceRepository $freelanceRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register_freelance');
        }

        $freelance = $freelanceRepository->find($id);

        if (null === $freelance) {
            return $this->redirectToRoute('app_register_freelance');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $freelance);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register_freelance');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register_freelance');
    }
}