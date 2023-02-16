<?php

namespace App\Controller;

use App\Entity\CodingLanguage;
use App\Entity\Comment;
use App\Entity\Db;
use App\Entity\Framework;
use App\Entity\Freelance;
use App\Entity\Methodology;
use App\Entity\Mission;
use App\Entity\Social;
use App\Entity\User;
use App\Entity\VersionControl;
use App\Form\CommentType;
use App\Form\DeleteSkillsType;
use App\Form\DescriptionProfilType;
use App\Form\DurationPrefType;
use App\Form\EditHeaderProfilType;
use App\Form\LanguageType;
use App\Form\LocationRemoteType;
use App\Form\TechnologyType;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        /** @var Freelance $freelance */

        if ($this->getUser() === null) {
            return $this->redirectToRoute('error401');
        }

        $freelance = $this->entityManager->getRepository(User::class)->find(['id' => $user]);

        $code = $freelance->getCodingLanguages();

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

        /** Parti supprimer une compétence */

        $user = $this->getUser();
        $form = $this->createForm(EditHeaderProfilType::class, $user);
        $form->handleRequest($request);
        $picture = $form->get('picture')->getData();

        if ($picture) {
            $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

            try {
                $picture->move(
                    $this->getParameter('picture'),
                    $newFilename
                );
            } catch (FileException $error) {
            }
            $freelance->setPicture($newFilename);
        }
        /** fin parti supprimer une compétence */

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
                if($coding =! null) {
                    $coding = $form->getData()['coding_language'];
                    foreach ($coding as $code) {
                        $freelance->addCodingLanguage($code);
                    }
                }
                if($framework =! null) {
                    $framework = $form->getData()['framework'];
                    foreach ($framework as $frame) {
                        $freelance->addFramework($frame);
                    }
                }

                if($db =! null) {
                    $db = $form->getData()['database'];
                    foreach ($db as $d) {
                        $freelance->addDb($d);
                    }
                }

                if($methodology =! null) {
                    $methodology = $form->getData()['methodology'];
                    foreach ($methodology as $method) {
                        $freelance->addMethodology($method);
                    }
                }
                if($versionning =! null) {
                    $versionning = $form->getData()['version_control'];
                    foreach ($versionning as $version) {
                        $freelance->addVersionControl($version);
                    }
                }
            }
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
            'freelance'=>$freelance,
            'code'=>$code,
        ]);
    }


    #[Route('/profil/{id}', name: 'app_profil_show')]
    public function show($id, Request $request, CommentRepository $commentRepository): Response
    {
        $freelance = $this->entityManager->getRepository(Freelance::class)->find($id);

        if (!$freelance) {
            return $this->render('errors/error500.html.twig', [
                'message' => 'La page demandée n\'a pas été trouvée.'
            ]);
        }
        $mission = $this->entityManager->getRepository(Mission::class)->find(['id'=>$freelance]);
        $commentaire = $this->entityManager->getRepository(Comment::class)->find(['id'=>$freelance]);
        $social = $this->entityManager->getRepository(Social::class)->find(['id'=>$freelance]);
        
        $firstCommentaires = $commentRepository->findLatest(3, $freelance);
        $restCommentaires = $commentRepository->findRest(3, $freelance);

        $user = $this->getUser() ?? null;

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment
                ->setCreatedAt(new DateTimeImmutable())
                ->setComments($user)
                ->setReceived($freelance)
                ;

            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            
            return $this->redirectToRoute('app_profil_show', ['id' => $freelance->getId()]);
        }
        
        return $this->render('profil/show.html.twig',[
        'freelance'=>$freelance,
            'mission'=>$mission,
            'commentaire'=>$commentaire,
            'social'=>$social,
            'user'=>$user,
            'commentForm' => $commentForm->createView(),
            'firstCommentaires' => $firstCommentaires,
            'restCommentaires' => $restCommentaires,
        ]);
    }

    /**
     * supprimer la photo de profil
     * @Route("/profil/delete/{id}", name="delete_photo_profil")
     */
    public function delete(Freelance $freelance)
    {
        $oldFile = $freelance->getPicture();
        if($oldFile) {
            unlink($this->getParameter('picture') . '/' . $oldFile);
        }


        return $this->redirectToRoute('app_profil');
    }
    private function deleteSkill(int $id, string $repositoryClass, string $removeMethod): Response
    {
        $user = $this->getUser();

        /** @var Freelance $freelance */
        $freelance = $this->entityManager->getRepository(User::class)->find(['id' => $user]);

        /** Prendra le nom du repository lié au skills */
        $skill = $this->entityManager->getRepository($repositoryClass)->find($id);

        /** Remove le skills via le repository sélectionner */
        $freelance->$removeMethod($skill);

        $this->entityManager->persist($freelance);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_profil');
    }

    #[Route('/profil/delete/coding/language/{id}', name: 'profil_delete_coding')]
    public function deleteCoding($id): Response
    {
        // Prend en parametre de la fonction , l'id du skills, la classe et la méthode via la classe
        return $this->deleteSkill($id, CodingLanguage::class, 'removeCodingLanguage');
    }

    #[Route('/profil/delete/framework/{id}', name: 'profil_delete_framework')]
    public function deleteFramework($id): Response
    {
        return $this->deleteSkill($id, Framework::class, 'removeFramework');
    }

    #[Route('/profil/delete/database/{id}', name: 'profil_delete_database')]
    public function deleteDb($id): Response
    {
        return $this->deleteSkill($id, Db::class, 'removeDb');
    }

    #[Route('/profil/delete/version/{id}', name: 'profil_delete_version')]
    public function deleteVersion($id): Response
    {
        return $this->deleteSkill($id, VersionControl::class, 'removeVersionControl');
    }

    #[Route('/profil/delete/methodology/{id}', name: 'profil_delete_methodology')]
    public function deleteMethodology($id): Response
    {
        return $this->deleteSkill($id, Methodology::class, 'removeMethodology');
    }

}
