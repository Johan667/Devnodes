<?php

namespace App\Controller;

use App\Entity\Freelance;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Knp\Component\Pager\PaginatorInterface;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
        $user = $this->getUser();
        $favorites = $paginator->paginate(
            $this->getUser()->getFavoriteFreelance(),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
            'favorites' => $favorites,
            'user' => $user,
        ]);
    }

    #[Route('/favorite/{id}', name: 'app_favorite_toggle', methods: ['POST'])]
    public function addFavorite(ManagerRegistry $doctrine, $id, Freelance $freelance): Response
    {
        $this->getUser()->addFavoriteFreelance($freelance);
        $doctrine->getManager()->flush();
        $this->addFlash("message", "Le freelance a été ajouté en Favoris.");
        return $this->json([
            'success' => true
        ], Response::HTTP_ACCEPTED);
    }

    #[Route('/favorite/{id}', name: 'app_favorite_delete', methods: ['DELETE'])]
    public function deleteFavorite(ManagerRegistry $doctrine, $id, Freelance $freelance): Response
    {
        $this->getUser()->removeFavoriteFreelance($freelance);
        $doctrine->getManager()->flush();
        $this->addFlash("message", "Le freelance a été supprimé des Favoris");
        return $this->json([
            'success' => true
        ], Response::HTTP_ACCEPTED);

        return $this->json([
            'success' => false
        ], Response::HTTP_NO_CONTENT);
    }
}
