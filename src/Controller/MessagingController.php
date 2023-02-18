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

        $messageReceive = $this->entityManager->getRepository(Message::class)->findBy(['recipient' => $user]);
        $messageSend = $this->entityManager->getRepository(Message::class)->findBy(['sender' => $user], ['datetime' => 'DESC']);


        return $this->render('messaging/index.html.twig', [
            'messageReceive' => $messageReceive,
            'messageSend' => $messageSend,
            'messages' => $messages,
        ]);
    }

    #[Route('/messaging/{missionId}', name: 'app_messaging_mission')]
    public function messaging(Request $request, $missionId): Response
    {
        $user = $this->getUser();

        $missionsReceived = $this->entityManager->getRepository(Mission::class)->findBy(['receiveMission'=>$this->getUser()]);

        $messages = $this->entityManager->getRepository(Message::class)->findBy(
            ['mission' => $missionId],
            ['datetime' => 'ASC']
        );

        $message = new Message();
        $date = new \DateTimeImmutable();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setDatetime($date);
            $message->setSender($this->getUser());

            foreach ($missionsReceived as $mission) {

                $sender = $mission->getSendMission();
                $message->setRecipient($sender);
                $message->setMission($mission);
                $this->entityManager->persist($message);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_messaging_mission', ['missionId' => $missionId]);
            }
        }


        return $this->render('messaging/messaging.html.twig', [
            'messages' => $messages,
            'newMessageForm' => $form->createView()
        ]);

}

}
