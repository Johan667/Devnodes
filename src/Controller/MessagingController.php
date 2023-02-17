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

        // Récupérer tous les messages pour la mission donnée
        $messages = $this->entityManager->getRepository(Message::class)->findBy(
            ['mission' => $missionId],
            ['datetime' => 'ASC']
        );

//        // Créer un nouveau message à envoyer pour la mission donnée
        $newMessage = new Message();
//        $newMessage->setMission($this->entityManager->getRepository(Mission::class)->find($missionId));
//        $newMessage->setSender($user);
//        $newMessage->setRecipient($this->entityManager->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']));
        $form = $this->createForm(MessageType::class, $newMessage);
        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->entityManager->persist($newMessage);
//            $this->entityManager->flush();
//            return $this->redirectToRoute('app_conversation', ['missionId' => $missionId]);
//        }

        return $this->render('messaging/messaging.html.twig', [
            'messages' => $messages,
            'newMessageForm' => $form->createView()
        ]);

}


}
