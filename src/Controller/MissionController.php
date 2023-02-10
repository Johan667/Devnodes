<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Entity\Mission;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        $missionsReceive = $this->entityManager->getRepository(Mission::class)->findBy(['receiveMission'=>$this->getUser()]);
        $missionsSend = $this->entityManager->getRepository(Mission::class)->findBy(['sendMission'=>$this->getUser()]);

        return $this->render('mission/index.html.twig', [
            'missionsReceive'=>$missionsReceive,
            'missionSend' => $missionsSend
        ]);
    }

    #[Route('/create/mission', name: 'create_mission')]
    public function create(Request $request, SluggerInterface $slugger): Response
    {
        $mission = new Mission;
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);
        $addFile = $form->get('addFile')->getData();

        if ($addFile) {
            $originalFilename = pathinfo($addFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $addFile->guessExtension();

            try {
                $addFile->move(
                    $this->getParameter('addFile'),
                    $newFilename
                );
            } catch (FileException $error) {
            }
            $mission->setAddFile($newFilename);
        }

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
        #[Route('/delete/mission/{id}', name: 'delete_mission')]
        public function delete(Request $request, Mission $mission): Response
        {

                $this->entityManager->remove($mission);
                $this->entityManager->flush();
                $this->addFlash("message", "Mission supprimée.");

            return $this->redirectToRoute('missions');
        }

}
