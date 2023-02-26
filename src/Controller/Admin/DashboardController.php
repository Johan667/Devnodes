<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Freelance;
use App\Entity\Message;
use App\Entity\Mission;
use App\Entity\SpokenLanguage;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
    * une fonction qui redirige vers la page d'administration
    */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    /**
    * Crée le dashboard admin
    */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Devnodes');
    }

    /**
    * Configurer les items du menu
    */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Freelance', 'fa-solid fa-user-tie', Freelance::class);
        yield MenuItem::linkToCrud('Mission', 'fa-solid fa-briefcase', Mission::class);
        yield MenuItem::linkToCrud('Message', 'fa-sharp fa-solid fa-message', Message::class);
        yield MenuItem::linkToCrud('Commentaire', 'fa-solid fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Langue', 'fa-solid fa-language', SpokenLanguage::class);
    }
}
