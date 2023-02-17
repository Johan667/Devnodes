<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Mission;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
//    private $entityManager;
//
//    public function __construct(EntityManagerInterface $entityManager)
//    {
//        $this->entityManager = $entityManager;
//    }
//
////    #[Route('/mission/{id}/messages', name:'app_messages_mission', methods: ['GET', 'POST'])]
////    public function messages(Mission $mission, MessageRepository $messageRepository, Request $request): Response
////    {
////        $messages = $messageRepository->findByMissionId($mission->getId());
////        $currentUser = $this->getUser();
////        $recipient = $mission->getSendMission() === $currentUser ? $mission->getReceiveMission() : $mission->getSendMission();
////
////        $messageReceive = $this->entityManager->getRepository(Message::class)->findBy(['recipient'=>$this->getUser()]);
////        $messageSend = $this->entityManager->getRepository(Message::class)->findBy(['sender'=>$this->getUser()]);
////
////
////        $message = new Message();
////        $form = $this->createForm(MessageType::class, $message);
////
////        $form->handleRequest($request);
////
////        if ($form->isSubmitted() && $form->isValid()) {
////
////            $message
////                ->setSender($currentUser)
////                ->setRecipient($recipient)
////                ->setMission($mission)
////                ->setDatetime(new \DateTimeImmutable());
////            $messageRepository->save($message, true);
////
////            return $this->redirectToRoute('missions', [], Response::HTTP_SEE_OTHER);
////        }
////
////        return $this->render('message/index.html.twig', [
////            'mission' => $mission,
////            'messages' => $messages,
////            'messageReceive' => $messageReceive,
////            'messageSend' => $messageSend,
////            'form' => $form->createView()
////        ]);
////    }
////
////    #[Route('/message', name: 'app_message_index', methods: ['GET'])]
////    public function index(MessageRepository $messageRepository): Response
////    {
////        $user = $this->getUser();
////        $messages = $messageRepository->findByUserId();
////
////        return $this->render('message/index.html.twig', [
////            'messages' => $messages,
////        ]);
////    }
////
////    #[Route('/mission/{id}/messages/new', name: 'app_message_new', methods: ['GET', 'POST'])]
////    public function new(Request $request, MessageRepository $messageRepository)
////    {
////        $message = new Message();
////        $form = $this->createForm(MessageType::class, $message);
////        $form->handleRequest($request);
////
////        if ($form->isSubmitted() && $form->isValid()) {
////            $messageRepository->save($message, true);
////        }
//
//
//
//     #[Route('/mission/{id}/messages', methods: ['GET', 'POST'])]
//     public function messages(Mission $mission, MessageRepository $messageRepository, ManagerRegistry $managerRegistry, Request $request)
//     {
//         $messages = $messageRepository->findByMissionId($mission->getId());
//         $currentUser = $this->getUser();
//         $users = [
//             $mission->getSendMission(),
//             $mission->getReceiveMission()
//         ];
//
//         $message = new Message();
//
//         $form = $this->createForm(MessageType::class, $message);
//         $reciever = null;
//
//         foreach ($users as $user) {
//             if($user != $this->getUser()){
//                 $reciever = $user;
//             }
//         }
//
//         $form->handleRequest($request);
//
//         if ($form->isSubmitted() && $form->isValid()) {
//             $message
//                 ->setSender($currentUser)
//                 ->setRecipient($reciever)
//                 ->setMission($mission)
//                 ->setDatetime(new \DateTimeImmutable());
//             $messageRepository->save($message, true);
//
//             return $this->redirectToRoute('missions', [], Response::HTTP_SEE_OTHER);
//         }
//
//         return $this->render('message/index.html.twig', [
//             'mission' => $mission,
//             'messages' => $messages,
//             'form' => $form->createView()
//         ]);
//
//     }
//
//     #[Route('/message', name: 'app_message_index', methods: ['GET'])]
//     public function index(): Response
//     {
//         $user = $this->getUser();
//         $messages = $this->entityManager->getRepository(Message::class)->find(['id' => $user]);
//
//         return $this->render('message/index.html.twig', [
//             'messages' => $messages,
//         ]);
//     }
//
//     #[Route('/message/new', name: 'app_message_new', methods: ['GET', 'POST'])]
//     public function new(Request $request, MessageRepository $messageRepository): Response
//     {
//         $message = new Message();
//         $form = $this->createForm(MessageType::class, $message);
//         $form->handleRequest($request);
//
//         if ($form->isSubmitted() && $form->isValid()) {
//             $message
//                 ->setDatetime(new \DateTimeImmutable()),
//                 ->setSender($this->getUser());
//             $messageRepository->save($message, true);
//
//             return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
//         }
//
//         return $this->renderForm('message/new.html.twig', [
//             'message' => $message,
//             'form' => $form,
//         ]);
//     }
//
//     #[Route('/message/{id}', name: 'app_message_show', methods: ['GET'])]
//     public function show(Message $message): Response
//     {
//         return $this->render('message/show.html.twig', [
//             'message' => $message,
//         ]);
//     }
//
//     #[Route('/message/{id}/edit', name: 'app_message_edit', methods: ['GET', 'POST'])]
//     public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
//     {
//         $form = $this->createForm(MessageType::class, $message);
//         $form->handleRequest($request);
//
//         if ($form->isSubmitted() && $form->isValid()) {
//             $messageRepository->save($message, true);
//
//             return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
//         }
//
//         return $this->renderForm('message/edit.html.twig', [
//             'message' => $message,
//             'form' => $form,
//         ]);
//     }
//
//     #[Route('/message/{id}', name: 'app_message_delete', methods: ['POST'])]
//     public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
//     {
//         if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
//             $messageRepository->remove($message, true);
//         }
//
//         return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
//     }
//
}