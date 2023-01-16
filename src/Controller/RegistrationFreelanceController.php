<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Form\FreelanceType;
use App\Repository\FreelanceRepository;
use App\Security\AppCustomAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationFreelanceController extends AbstractController
{

    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register/freelance', name: 'app_register_freelance')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $freelance= new Freelance();
        $form = $this->createForm(FreelanceType::class, $freelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $freelance->setRoles((array)"ROLE_FREELANCE");
            // encode the plain password
            $freelance->setPassword(
                $userPasswordHasher->hashPassword(
                    $freelance,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($freelance);
            $entityManager->flush();

            $this->redirectToRoute('app_login');

            // generate a signed url and email it to the user
            //    $this->emailVerifier->sendEmailConfirmation('app_verify_email', $freelance,
            //        (new TemplatedEmail())
            //            ->from(new Address('admin@le.com', 'Look Escort'))
            //            ->to($freelance->getEmail())
            //            ->subject('Please Confirm your Email')
            //            ->htmlTemplate('registration/confirmation_email.html.twig')
            //    );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $freelance,
                $authenticator,
                $request
            );
        }

        return $this->render('registration_freelance/index.html.twig', [
            'registrationForm' => $form->createView(),
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