<?php

namespace App\Controller;

use App\Form\SearchForm2;
use App\Repository\FreelanceRepository;
use Doctrine\DBAL\Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultBDRController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/search/freelances')]
    public function index(Request $request, FreelanceRepository $repository, PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('language');
        $city = $request->query->get('city');

        $user = $this->getUser() ?? null;
        /*$freelances = $repository->findSearch([
            'q' => $query,
            'city' => $city
        ]);*/

        // les profils paginé
        $freelances = $paginator->paginate(
            $repository->findSearch([
                'language' => $query,
                'city' => $city
            ]),
            $request->query->getInt('page', 1),
            12
        );

//        $searchFreelance2 = $this->createForm(SearchForm2::class, null);
//        // crée le formulaire configuré dans le dossier FORM
//        $searchFreelance2->handleRequest($request);
//        // traite les données du formulaire
//
//
//        if ($searchFreelance2->isSubmitted() && $searchFreelance2->isValid()) {
//            // si le formulaire est envoyé et validé alors :
//            $freelances2 = $repository->findSearch2($searchFreelance2->getData());
//            $request->query->remove('_token');
//            // on passe le formulaire a la fonction du repository qui est un tableau classic : FreelanceRepository.php
//            return $this->redirectToRoute('app_resultbdr_index', $request->query->all());
//        };
//
//        $freelances2 = $repository->findSearch2([
//            'language' => $request->query->get('codingLanguages'),
//        ]);
//        // $freelances = le tableau des freelances trouvés.

        return $this->render('result_bdr/index.html.twig', [
//            'searchFreelance2' => $searchFreelance2->createView(),
            'freelances' => $freelances ?? null,
//            'freelances2' => $freelances2 ?? null,
            'user' => $user ?? null,
        ]);
    }

    }
