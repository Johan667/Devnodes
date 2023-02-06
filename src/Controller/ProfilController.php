<?php

namespace App\Controller;

use App\Entity\CodingLanguage;
use App\Entity\Comment;
use App\Entity\Freelance;
use App\Entity\Mission;
use App\Entity\Social;
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
        $user = $this->getUser();
        /** @var Freelance $freelance */

        $freelance = $this->entityManager->getRepository(User::class)->find(['id' => $user]);

        $forms = [
            'base' => $this->createForm(EditHeaderProfilType::class, $freelance),
            'tech' => $this->createForm(TechnologyType::class, null, [
                'freelance' => $freelance
            ]),
            'loc' => $this->createForm(LocationRemoteType::class, $freelance),
            'dur' => $this->createForm(DurationPrefType::class, $freelance),
            'desc' => $this->createForm(DescriptionProfilType::class, $freelance),
            'lang' => $this->createForm(LanguageType::class, $freelance),
        ];

        foreach ($forms as $form) {
            $form->handleRequest($request);
        }

        $formNames = ['base','tech', 'loc', 'dur', 'desc', 'lang'];

        foreach ($formNames as $formName) {
            if (!isset($forms[$formName])) {
                continue;
            }

            $form = $forms[$formName];

            if (!$form->isSubmitted() || !$form->isValid()) {
                continue;
            }

            if ($formName === 'tech') {
                $coding = $form->getData()['coding_language'];
                $framework = $form->getData()['framework'];
                $db = $form->getData()['database'];
                $methodology = $form->getData()['methodology'];
                $version = $form->getData()['version_control'];

                $freelance->addCodingLanguage($coding);
                $freelance->addFramework($framework);
                $freelance->addDb($db);
                $freelance->addMethodology($methodology);
                $freelance->addVersionControl($version);
            }

            $form->persist($freelance);
        }

        $this->entityManager->flush();


//            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
//            return $this->redirectToRoute('app_profil');


        return $this->render('profil/index.html.twig', [
            'freelanceBase' => $forms['base']->createView(),
            'freelanceBiographie' => $forms['desc']->createView(),
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
        $mission = $this->entityManager->getRepository(Mission::class)->find(['id'=>$freelance]);
        $commentaire = $this->entityManager->getRepository(Comment::class)->find(['id'=>$freelance]);
        $social = $this->entityManager->getRepository(Social::class)->find(['id'=>$freelance]);

        $user = $this->getUser() ?? null;

        return $this->render('profil/show.html.twig',[
        'freelance'=>$freelance,
            'mission'=>$mission,
            'commentaire'=>$commentaire,
            'social'=>$social,
            'user'=>$user,
        ]);
    }

}
