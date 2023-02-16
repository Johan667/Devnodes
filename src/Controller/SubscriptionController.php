<?php

namespace App\Controller;
use App\Entity\Freelance;
use App\Entity\User;
use App\Service\CheckoutStripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class SubscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

        $successUrl = $this->generateUrl('subscription_success', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $cancelUrl = $this->generateUrl('subscription_error', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $session = $checkoutStripeService->create($user, $successUrl, $cancelUrl);

        return $this->redirect($session->url);
    }

    #[Route('/subscription/success', name: 'subscription_success')]
    public function success(SessionInterface $session)
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();
        /** @var Freelance $freelance */

        $freelance = $this->entityManager->getRepository(User::class)->find(['id' => $user]);
        if ($freelance === $this->getUser()) {
            // Modifier le rôle de l'utilisateur en "ROLE_VIP"
            $freelance->setRoles(["ROLE_VIP"]);
            $freelance->setIsVip(1);
            // Enregistrer les modifications en base de données
            $this->entityManager->persist($freelance);
            $this->entityManager->flush();
            // Ajouter un message flash
            $this->addFlash('message', 'Vous êtes maintenant VIP. Veuillez vous reconnecter pour accéder à vos avantages.');

            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
        return $this->render('subscription/success.html.twig');
    }

    #[Route('/subscription/error', name: 'subscription_error')]
    public function error()
    {
        return $this->render('subscription/error.html.twig');
    }
}
