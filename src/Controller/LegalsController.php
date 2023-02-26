<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class LegalsController extends AbstractController
{
    /**
     * Renvoi vers la page lié à la gestion des cookie
     */
    #[Route('/cookies', name: 'app_cookies')]
    public function cookies(): Response
    {
        return $this->render('legals/cookies.html.twig', [
        ]);
    }

    /**
     * Renvoi vers la page lié à la charte du développeur
     */
    #[Route('/charts', name: 'app_charts')]
    public function charts(): Response
    {
        return $this->render('legals/charts.html.twig', [
        ]);
    }
    /**
     * Renvoi vers la page lié aux conditions générales d'utilisation
     */
    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {

        return $this->render('legals/cgu.html.twig', [
        ]);
    }

    #[Route('/privacy', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('legals/privacy.html.twig', [
        ]);
    }

    /**
     * Crée un formulaire de contact en utilisant la classe ContactType et gère la soumission de ce formulaire en envoyant un email à une adresse spécifiée.
     * Enfin, il renvoie une réponse HTTP sous forme d'une vue Twig.
     */
    #[Route('/contact', name: 'app_contact')]
    public function contact(MailerInterface $mailer,Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail = (new Email())
                ->from($form->get('email')->getData())
                ->to(new Address('devnodes.contact@gmail.com', 'Admin Devnodes'))
                ->subject($form->get('objet')->getData())
                ->text($form->get('message')->getData())
            ;
            $mailer->send($mail);
            $this->addFlash('message', 'Votre demande à bien été prise en compte, nous y repondrons au plus tard 48 heures après votre demande ! ');
        }

        return $this->render('legals/contact.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
