<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Entity\Mission;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/create/mission', name: 'create_mission')]
    public function create(Request $request): Response
    {
        $mission = new Mission;
        $form = $this->createForm(MissionType::class, $mission);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->setSendMission($this->getUser());
            $freelance = $this->entityManager->getRepository(Freelance::class)->find(['id'=>$request->get('id')]);
            $mission->setReceiveMission($freelance);

            $this->entityManager->persist($mission);
            $this->entityManager->flush();

            $this->addFlash("message", "Mission envoyé avec succès.");
            return $this->redirectToRoute("app_home");
        }

        return $this->render("mission/create.html.twig", [
            'form' => $form->createView()
        ]);

    }

}
