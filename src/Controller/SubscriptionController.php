<?php

namespace App\Controller;

use App\Service\CheckoutStripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class SubscriptionController extends AbstractController
{

    #[Route('/subscription', name: 'app_subscription')]
    public function index()
    {
        // ici afficher l'abonnement et les avantage + rediriger vers le checkout
        return $this->render('subscription/index.html.twig');
    }

    #[Route('/subscription/create', name: 'subscription_create')]
    public function create(CheckoutStripeService $checkoutStripeService)
    {
        $user = $this->getUser();
        if ($this->getUser() === null) {
            return $this->redirectToRoute('subscription_error');
        }

        $successUrl = $this->generateUrl('subscription_success', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $cancelUrl = $this->generateUrl('subscription_error', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $session = $checkoutStripeService->create($user, $successUrl, $cancelUrl);

        return $this->redirect($session->url);
    }

    #[Route('/subscription/success', name: 'subscription_success')]
    public function success()
    {
        // if redirect succes setSuscribe Freelance(); look webhook

        return $this->render('subscription/success.html.twig');
    }


    #[Route('/subscription/error', name: 'subscription_error')]
    public function error()
    {
        return $this->render('subscription/error.html.twig');
    }
}
