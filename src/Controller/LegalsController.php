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
    #[Route('/legals', name: 'app_legals')]
    public function index(): Response
    {
        return $this->render('legals/index.html.twig', [
            'controller_name' => 'LegalsController',
        ]);
    }

    #[Route('/charts', name: 'app_charts')]
    public function charts(): Response
    {
        return $this->render('legals/charts.html.twig', [
        ]);
    }

    #[Route('/charts', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('legals/cgu.html.twig', [
        ]);
    }

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
