<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Entity\Message;
use App\Entity\Mission;
use App\Form\MessageType;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Workflow\WorkflowInterface;


class MissionController extends AbstractController
{
    private $entityManager;
    private $missionWorkflow;

    // définit le constructeur d'une classe qui utilise l'injection de dépendances pour recevoir deux services en paramètres
    public function __construct(EntityManagerInterface $entityManager, WorkflowInterface $missionWorkflow)
    {
        $this->entityManager = $entityManager;
        $this->missionWorkflow = $missionWorkflow;
    }

    #[Route('/missions', name: 'missions')]
    public function index(Request $request): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }

        // Requête qui permet de récupérer un tableau d'objets Mission triés par date de début décroissante,
        // En filtrant les missions dont l'utilisateur courant est le destinataire.
        $missionsReceived = $this->entityManager->getRepository(Mission::class)->findBy(
            ['receiveMission' => $this->getUser()],
            ['startDate' => 'DESC']
        );

        // Requête qui permet de récupérer un tableau d'objets Mission triés par date de début décroissante,
        // En filtrant les missions dont l'utilisateur courant est l'expediteur.
        $missionSend = $this->entityManager->getRepository(Mission::class)->findBy(
            ['sendMission' => $this->getUser()],
            ['startDate' => 'DESC']
        );

        // Crée une nouvelle instance de l'objet Message et DateTimeImmutable.
        $message = new Message();
        $date = new \DateTimeImmutable();

        //  Créer un formulaire à partir d'un objet Message
        // Gérer sa soumission via une requête HTTP.
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        // lors de la soumission d'un formulaire :
        // créé à partir d'un objet Message et permet de créer un nouveau message et de l'enregistrer dans la base de données.
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setDatetime($date);
            $message->setSender($this->getUser());

            foreach ($missionsReceived as $mission) {
                $sender = $mission->getSendMission();
                $message->setRecipient($sender);
                $message->setMission($mission);
                $this->entityManager->persist($message);
                $this->entityManager->flush();
            }
        }
        // A la fin d'une action d'un contrôleur Symfony et renvoie une réponse HTTP sous forme d'une vue Twig.
        return $this->render('mission/index.html.twig', [
            'missionsReceive' => $missionsReceived,
            'missionSend' => $missionSend,
            'form' => $form->createView(),
        ]);

}

    #[Route('/create/mission', name: 'create_mission')]
    public function create(Request $request, SluggerInterface $slugger): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }

        // crée un formulaire à partir de cette instance.
        // Ensuite, il gère la requête HTTP envoyée par l'utilisateur pour ce formulaire.
        // Enfin, il extrait les données du champ "addFile" du formulaire
        $mission = new Mission;
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);
        $addFile = $form->get('addFile')->getData();

        //  Permet de gérer le fichier uploadé par l'utilisateur dans le champ "addFile"
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

        // Utilise un workflow pour gérer l'état de l'entité Mission, après la soumission d'un formulaire.
        if ($form->isSubmitted() && $form->isValid()) {

            //workflow / state Machine
            try {
                $this->missionWorkflow->apply($mission, 'to_pending');
            } catch (LogicException $exception) {
                //
            }

            // met à jour une entité Mission avec les données soumises par l'utilisateur via un formulaire,
            // puis enregistre cette entité dans la base de données à l'aide de l'objet EntityManager de Doctrine.
            $mission->setSendMission($this->getUser());
            $freelance = $this->entityManager->getRepository(Freelance::class)->find(['id'=>$request->get('id')]);
            $mission->setReceiveMission($freelance);

            $this->entityManager->persist($mission);
            $this->entityManager->flush();

            $this->addFlash("message", "Mission envoyé avec succès.");
            return $this->redirectToRoute("missions");
        }

        return $this->render("mission/create.html.twig", [
            'form' => $form->createView()
        ]);

    }
        #[Route('/delete/mission/{id}', name: 'delete_mission')]
        public function delete(Request $request, Mission $mission): Response
        {
            // Supprimer une mission

            // Vérifier si l'utilisateur est connecté
            if (!$this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('app_login');
            }

                $this->entityManager->remove($mission);
                $this->entityManager->flush();
                $this->addFlash("message", "Mission supprimée.");

            return $this->redirectToRoute('missions');
        }

    #[Route('/mission/bulle', name: 'bulle_mission')]
    public function bulle(): Response
    {
            $missionCount = $this->entityManager->getRepository(Mission::class)->findBy(['receiveMission' => $this->getUser()]);

        return $this->render('mission/bulle.html.twig', [
            'missionCount' => count($missionCount),
        ]);
    }


    #[Route('/mission/{id}/{to}', name: 'mission_status_change', methods: ['POST'])]
    public function changeStatus(Mission $mission, string $to, EntityManagerInterface $entityManager): Response
    {
        // Applique une transition à une entité Mission en utilisant un workflow,
        // puis enregistre l'entité mise à jour dans la base de données à l'aide de l'objet EntityManager de Doctrine.
        // Enfin, il ajoute un message flash pour informer l'utilisateur de la mise à jour de la mission et redirige vers une autre page.

        try {
            $this->missionWorkflow->apply($mission, $to);
        } catch (LogicException $exception) {
            $this->addFlash('error', 'Impossible de changer le statut de la mission : '.$exception->getMessage());
        }

        $entityManager->persist($mission);
        $entityManager->flush();

        $this->addFlash('message', 'Le statut de la mission a été mis à jour avec succès !');

        return $this->redirectToRoute('missions');
    }




}
