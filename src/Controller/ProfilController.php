<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Entity\User;
use App\Repository\CodingLanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        /** @var Freelance $user */
        $user = $this->getUser();
        $freelance = $this->entityManager->getRepository(Freelance::class);


        return $this->render('profil/index.html.twig', [
        'freelance'=>$freelance,
        ]);
    }

    #[Route('/profil/{id}', name: 'app_profil_show')]
    public function show($id): Response
    {
        $freelance = $this->entityManager->getRepository(Freelance::class)->find($id);


        return $this->render('profil/show.html.twig',[
        'freelance'=>$freelance,
            ]);
    }
}
