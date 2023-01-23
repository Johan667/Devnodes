<?php

namespace App\Controller;

use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/missions', name: 'missions')]
    public function index(): Response
    {
        // Si ce n'est pas le bon utilisateur on renvoi sur home
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $missions = $this->entityManager->getRepository(Mission::class)->findAll(['start_date' => 'DESC']);


        return $this->render('mission/index.html.twig', [
            'missions'=>$missions,
        ]);
    }

}
