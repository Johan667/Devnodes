<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/delete/{id}', name: 'app_comment_delete')]
    public function delete(Request $request, Comment $comment): Response
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        $this->addFlash('message', 'Votre commentaire a bien été supprimé');
        return $this->redirect($request->headers->get('referer'));
    }
}
