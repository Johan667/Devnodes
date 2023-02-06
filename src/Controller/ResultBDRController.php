<?php

namespace App\Controller;

use App\Repository\FreelanceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultBDRController extends AbstractController
{
    #[Route('/search/freelances')]
    public function index(Request $request, FreelanceRepository $repository, PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('q');
        $city = $request->query->get('city');

        $user = $this->getUser() ?? null;
        /*$freelances = $repository->findSearch([
            'q' => $query,
            'city' => $city
        ]);*/

        // les profils paginé
        $freelances = $paginator->paginate(
            $repository->findSearch([
                'q' => $query,
                'city' => $city
            ]),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('result_bdr/index.html.twig', [
            'freelances' => $freelances ?? null,
            'user' => $user ?? null,
        ]);
    }

    }
