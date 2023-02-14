<?php

namespace App\Controller;

use App\Form\SearchForm;
use App\Repository\FreelanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * barre de recherche multi filtre
     * @Route("/", name="app_home")
     */
    public function bdr(FreelanceRepository $repository, Request $request): Response
    {

        $searchFreelance = $this->createForm(SearchForm::class, null);
        // crée le formulaire configuré dans le dossier FORM
        $searchFreelance->handleRequest($request);
        // traite les données du formulaire


        if ($searchFreelance->isSubmitted() && $searchFreelance->isValid()) {
            // si le formulaire est envoyé et validé alors :
            $request->query->remove('_token');
            // on passe le formulaire a la fonction du repository qui est un tableau classic : FreelanceRepository.php

            return $this->redirectToRoute('app_resultbdr_index', $request->query->all());
        };

        return $this->render('home/index.html.twig', [
            'searchFreelance' => $searchFreelance->createView()
        ]);
    }
}
