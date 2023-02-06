<?php

namespace App\Controller;

use App\Entity\Freelance;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(): Response
    {
        
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
            'favorites' => $this->getUser()->getFavoriteFreelance(),
        ]);
    }

    #[Route('/favorite/{id}', name: 'app_favorite_toggle', methods: ['POST'])]
    public function addFavorite(ManagerRegistry $doctrine, $id, Freelance $freelance): Response
    {
        $this->getUser()->addFavoriteFreelance($freelance);
        $doctrine->getManager()->flush();
            return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }

    #[Route('/favorite/{id}', name: 'app_favorite_delete', methods: ['DELETE'])]
    public function deleteFavorite(ManagerRegistry $doctrine, $id, Freelance $freelance): Response
    {
        $this->getUser()->removeFavoriteFreelance($freelance);
        $doctrine->getManager()->flush();
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }
}
