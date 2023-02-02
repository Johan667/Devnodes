<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Entity\User;
use App\Form\DescriptionProfilType;
use App\Form\EditHeaderProfilType;
use App\Form\TechnologyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        /** @var Freelance $user */
        $user = $this->getUser();
        $freelance = $this->entityManager->getRepository(User::class)->find(['id'=>$this->getUser()]);

        // Formulaires

        $freelanceBase = $this->createForm(EditHeaderProfilType::class, $freelance);
        $freelanceTechnology = $this->createForm(TechnologyType::class);
        $freelanceDescription = $this->createForm(DescriptionProfilType::class,$freelance);

        $freelanceBase->handleRequest($request);
        $freelanceDescription->handleRequest($request);

        // Traitement

        if ($freelanceBase->isSubmitted() && $freelanceBase->isValid() ||
            $freelanceTechnology->isSubmitted() && $freelanceTechnology->isValid() ||
            $freelanceDescription->isSubmitted() && $freelanceDescription->isValid())

        {

            $this->entityManager->persist($freelance);
            $this->entityManager->flush();


            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/index.html.twig', [
            'freelanceBase' => $freelanceBase->createView(),
            'freelanceTechnology' => $freelanceTechnology->createView(),
            'freelanceDescription' => $freelanceDescription->createView(),
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

    #[Route('/profil/test', name: 'app_profil_test')]
    public function test(): Response
    {

        return $this->render('profil/test.html.twig',[

        ]);
    }
}
