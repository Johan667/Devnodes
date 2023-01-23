<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalsController extends AbstractController
{
    #[Route('/legals', name: 'app_legals')]
    public function index(): Response
    {
        return $this->render('legals/index.html.twig', [
            'controller_name' => 'LegalsController',
        ]);
    }

    #[Route('/charts', name: 'app_charts')]
    public function charts(): Response
    {
        return $this->render('legals/charts.html.twig', [
        ]);
    }
}
