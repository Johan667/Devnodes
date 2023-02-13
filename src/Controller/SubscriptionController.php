<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Charge;
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
    public function create(Request $request) // injecte le service
    {
//        $checkoutStripeService = CheckoutStripeService->create($user, $subscriptionSuccess, $subscriptionError);
//        return $this->redirect($checkoutStripeService->url);

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        // https://stripe.com/docs/payments/checkout/how-checkout-works

        // la clé d'API: dans le .env.local: https://stackoverflow.com/questions/52151783/symfony-4-get-env-parameter-from-a-controller-is-it-possible-and-how
        Stripe::setApiKey("sk_test_51MZy4JH9N1RXfBmpAq5CxTUrsV2b4iVludNECKajuQieLUrMCTb6zzKUe94eLtZ2k8xG20GSx3KKKWegrWr34NzT00JTn5PJIr");
        // mettre tout le code d'abonnement dans un service
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => 'price_1MazccH9N1RXfBmpxT7mI3ok', // à mettre dans .env.local
                'quantity' => 1,
            ]],
            'customer_email' => $this->getUser()->getEmail(),
            'mode' => 'subscription',
            'success_url' => $this->generateUrl('subscription_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('subscription_error', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkout_session->url);

        // Si il n'y à pas d'utilisateur en cours renvoi vers error

        if ($this->getUser() === null) {
            return $this->redirectToRoute('subscription_error');
        }

        // Création du client

        $customer = \Stripe\Customer::create([
            "email" => $this->getUser()->getEmail(),
        ]);

        // On get le token Stripe

        $token = $request->request->get('stripeToken');

        // On crée la source avec le type de paiement et son token

        $source = \Stripe\Source::create([
            "type" => "card",
            "token" => $token,
        ]);

        // On crée la source du client

        $customer->sources->create(["source" => $source->id]);


        // Create a charge: this will charge the user's card

        try {
            $charge = Charge::create(array(
                "customer" => $customer,
                "amount" => 999, // Amount in cents
                "currency" => "eur",
                "source" => $source,
                "payment_method_types" => ['card'],
                "description" => "Abonnement Prenium",
                "receipt_email" => $this->getUser()->getEmail(),
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
