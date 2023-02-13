<?php
namespace App\Service;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CheckoutStripeService
{
    private UrlGeneratorInterface $urlGenerator;
    private string $stripeApiKey;
    private string $priceStripe;

    public function __construct( string $stripeApiKey, string $priceStripe)
    {
        $this->stripeApiKey = $stripeApiKey;
        $this->priceStripe = $priceStripe;
    }

    public function create(
        UserInterface $user,
        string $successUrl,
        string $cancelUrl
    ): Session
    {
        Stripe::setApiKey($this->stripeApiKey);

        $checkoutSession = Session::create([
            'line_items' => [[
                'price' => $this->priceStripe,
                'quantity' => 1,
            ]],
            'customer_email' => $user->getEmail(),
            'mode' => 'subscription',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);

        return $checkoutSession;
    }
}
