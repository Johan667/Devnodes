<?php

namespace App\Controller;

use App\Repository\FreelanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultBDRController extends AbstractController
{
    #[Route('/search/freelances')]
    public function index(Request $request, FreelanceRepository $repository): Response
    {
        $query = $request->query->get('q');
        $city = $request->query->get('city');
        $freelances = $repository->findSearch([
            'q' => $query,
            'city' => $city
        ]);

        return $this->render('result_bdr/index.html.twig', [
            'freelances' => $freelances ?? null,
        ]);
    }
}
