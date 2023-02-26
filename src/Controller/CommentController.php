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

/**
 * Cette classe est utilisée pour gérer les commentaires des utilisateurs.
 */
#[Route('/comment')]
class CommentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Cette méthode est utilisée pour supprimer un commentaire.
     *Elle prend en paramètre la requête HTTP et un objet Comment.
     *La méthode redirect est utilisée pour rediriger l'utilisateur vers la page précédente.
     */
    #[Route('/delete/{id}', name: 'app_comment_delete')]
    public function delete(Request $request, Comment $comment): Response
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        $this->addFlash('message', 'Votre commentaire a bien été supprimé');
        return $this->redirect($request->headers->get('referer'));
    }
}
