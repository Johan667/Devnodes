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

    #[Route('/error404', name: 'error404')]
    public function error404(): Response
    {
        return $this->render('errors/error404.html.twig', [
        ]);
    }

    #[Route('/error500', name: 'error500')]
    public function error500(): Response
    {
        return $this->render('errors/error500.html.twig', [
        ]);
    }
}
