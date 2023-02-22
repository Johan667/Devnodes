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

    // définit le constructeur d'une classe qui utilise l'injection de dépendances pour recevoir un service en paramètre
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

        // Crée plusieurs formulaires pour permettre à un utilisateur connecté de modifier différentes parties de son profil Freelance.
        // Les formulaires sont créés à partir de différentes classes de formulaire
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

        // Traite un fichier image soumis avec un formulaire de modification de profil Freelance en générant un nom de fichier unique
        // et en le déplaçant vers un répertoire spécifié.
        // Enfin, le nom de fichier de l'image est enregistré dans l'entité Freelance correspondante, qui est elle-même enregistrée dans la base de données.
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
            $this->entityManager->flush();
            return $this->redirectToRoute('app_profil');
        }

        /** fin parti supprimer une compétence */

        // Pour chaques formulaire on envoie sa requete HTTP.
        foreach ($forms as $form) {
            $form->handleRequest($request);
        }

        // Crée un tableau qui défini le noms des formulaires pour les passé à la vue plus tard
        $formNames = ['base','tech', 'loc', 'dur', 'desc', 'lang'];

        // Crée plusieurs formulaires pour permettre à un utilisateur connecté de modifier différentes parties de son profil Freelance,
        // puis traite les données soumises par les formulaires
        // pour mettre à jour le profil Freelance de l'utilisateur en ajoutant les données extraites aux entités Freelance correspondantes.
        // Enfin, l'entité Freelance est enregistrée dans la base de données.

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
            return $this->render('errors/error404.html.twig', [
                'message' => 'La page demandée n\'a pas été trouvée.'
            ]);
        }
        $mission = $this->entityManager->getRepository(Mission::class)->find(['id'=>$freelance]);
        $commentaire = $this->entityManager->getRepository(Comment::class)->find(['id'=>$freelance]);
        $social = $this->entityManager->getRepository(Social::class)->find(['id'=>$freelance]);
        
        $firstCommentaires = $commentRepository->findLatest(3, $freelance);
        $restCommentaires = $commentRepository->findRest(3, $freelance);

        $user = $this->getUser() ?? null;

        /**
         * La partie commentaires
         */

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment
                ->setCreatedAt(new DateTimeImmutable())
                ->setComments($user)
                ->setReceived($freelance)
                ;
            
            // La partie pour le parent (reponse a un commentaire)
            $parentid = $commentForm->get("parentid")->getData();
            if ($parentid != null) {
                $parent = $this->entityManager->getRepository(Comment::class)->find($parentid);
                $comment->setParent($parent);
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé');

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
        // Appelle une méthode générique deleteSkill() pour supprimer une compétence de programmation de l'entité Freelance
        // correspondante en utilisant la classe CodingLanguage et la méthode removeCodingLanguage.
        // La méthode deleteCoding() renvoie une réponse HTTP.

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
