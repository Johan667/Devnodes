<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Mission;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MessagingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/messaging', name: 'app_messaging')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $messages = $this->entityManager->getRepository(Message::class)->findAll();
        $messageReceive = $this->entityManager->getRepository(Message::class)->findBy(['recipient' => $user], ['datetime' => 'DESC']);
        $messageSend = $this->entityManager->getRepository(Message::class)->findBy(['sender' => $user], ['datetime' => 'DESC']);

        return $this->render('messaging/index.html.twig', [
            'messageReceive' => $messageReceive,
            'messageSend' => $messageSend,
            'messages' => $messages,
        ]);
    }

    #[Route('/messaging/{missionId}', name: 'app_messaging_mission')]
    public function messaging(Request $request, int $missionId): Response
    {
        $user = $this->getUser();
        $missionRepository = $this->entityManager->getRepository(Mission::class);
        $mission = $missionRepository->find($missionId);

        // Vérifie si l'utilisateur a accès à cette mission
        if (!$mission || ($mission->getSendMission() !== $user && $mission->getReceiveMission() !== $user)) {
            throw $this->createNotFoundException('La mission n\'existe pas ou vous n\'avez pas le droit d\'y accéder.');
        }

        $messages = $this->entityManager->getRepository(Message::class)->findBy(
            ['mission' => $missionId],
            ['datetime' => 'ASC']
        );

        $message = new Message();
        $date = new \DateTimeImmutable();
        $newMessageForm = $this->createForm(MessageType::class, $message);
        $newMessageForm->handleRequest($request);

        if ($newMessageForm->isSubmitted() && $newMessageForm->isValid()) {
            $message->setDatetime($date);
            $message->setSender($user);

            if ($mission->getSendMission() === $user) {
                $recipient = $mission->getReceiveMission();
            } else {
                $recipient = $mission->getSendMission();
            }

            $message->setRecipient($recipient);
            $message->setMission($mission);
            $this->entityManager->persist($message);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_messaging_mission', ['missionId' => $missionId]);
        }

        return $this->render('messaging/messaging.html.twig', [
            'title' => $mission->getTitle(), // Ajoutez cette ligne
            'messages' => $messages,
            'newMessageForm' => $newMessageForm->createView(),
        ]);
    }
}
