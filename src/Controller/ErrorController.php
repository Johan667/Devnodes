<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error401', name: 'error401')]
    public function error401(): Response
    {
        return $this->render('errors/error401.html.twig', [
        ]);
    }
}
