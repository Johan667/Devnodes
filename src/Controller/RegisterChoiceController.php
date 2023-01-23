<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterChoiceController extends AbstractController
{
    #[Route('/register/choice', name: 'app_register_choice')]
    public function index(): Response
    {
        return $this->render('register_choice/index.html.twig', [
            'controller_name' => 'RegisterChoiceController',
        ]);
    }
}
