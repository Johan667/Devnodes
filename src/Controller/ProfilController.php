<?php

namespace App\Controller;

use App\Entity\Freelance;
use App\Entity\User;
use App\Form\DescriptionProfilType;
use App\Form\DurationPrefType;
use App\Form\EditHeaderProfilType;
use App\Form\LanguageType;
use App\Form\LocationRemoteType;
use App\Form\TechnologyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request): Response
    {
        /** @var Freelance $user */
        $user = $this->getUser();
        $freelance = $this->entityManager->getRepository(User::class)->find(['id'=>$user]);

        $forms = [
            'base' => $this->createForm(EditHeaderProfilType::class, $freelance),
            'tech' => $this->createForm(TechnologyType::class),
            'loc' => $this->createForm(LocationRemoteType::class, $freelance),
            'dur' => $this->createForm(DurationPrefType::class, $freelance),
            'desc' => $this->createForm(DescriptionProfilType::class, $freelance),
            'lang' => $this->createForm(LanguageType::class, $freelance),
        ];

        foreach ($forms as $form) {
            $form->handleRequest($request);
        }

        if (array_reduce($forms, function ($isSubmitted, $form) {
            return $isSubmitted || ($form->isSubmitted() && $form->isValid());
        }, false)) {
            $this->entityManager->persist($freelance);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/index.html.twig', [
            'freelanceBase' => $forms['base']->createView(),
            'freelanceDescription' => $forms['desc']->createView(),
            'freelanceLocation' => $forms['loc']->createView(),
            'freelanceDuration' => $forms['dur']->createView(),
            'freelanceLanguage' => $forms['lang']->createView(),
            'freelanceTechnology' => $forms['tech']->createView(),
        ]);
    }


    #[Route('/profil/{id}', name: 'app_profil_show')]
    public function show($id): Response
    {
        $freelance = $this->entityManager->getRepository(Freelance::class)->find($id);


        return $this->render('profil/show.html.twig',[
        'freelance'=>$freelance,
            ]);
    }

}
