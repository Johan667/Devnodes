<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Charge;

class SubscriptionController extends AbstractController
{

    #[Route('/subscription', name: 'app_subscription')]
    public function index()
    {
        return $this->render('subscription/index.html.twig');
    }


    #[Route('/subscription/create', name: 'subscription_create')]
    public function create(Request $request)
    {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey("sk_test_51MZy4JH9N1RXfBmpAq5CxTUrsV2b4iVludNECKajuQieLUrMCTb6zzKUe94eLtZ2k8xG20GSx3KKKWegrWr34NzT00JTn5PJIr");

        // Get the credit card details submitted by the form
        $token = $request->request->get('stripeToken');
        $email = $request->request->get('email');

        // Create a charge: this will charge the user's card
        try {
            $charge = Charge::create(array(
                "amount" => 999, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Abonnement Prenium",
                "receipt_email" => "none",
            ));

            // The charge was successful, redirect to a success page
            return $this->redirectToRoute('subscription_success');
        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
            return $this->redirectToRoute('subscription_error');
        }
    }


    #[Route('/subscription/success', name: 'subscription_success')]
    public function success()
    {
        return $this->render('subscription/success.html.twig');
    }


    #[Route('/subscription/error', name: 'subscription_error')]
    public function error()
    {
        return $this->render('subscription/error.html.twig');
    }
}
