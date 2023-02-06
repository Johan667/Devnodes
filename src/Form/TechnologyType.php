<?php
namespace App\Form;

use App\Entity\CodingLanguage;
use App\Entity\Framework;
use App\Entity\Db;
use App\Entity\Freelance;
use App\Entity\Methodology;
use App\Entity\User;
use App\Entity\VersionControl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $freelance = $this->entityManager->getRepository(Freelance::class)->find($options['freelance']);

        $codingLanguages = $freelance->getCodingLanguages();
        $framework = $freelance->getFrameworks();
        $database = $freelance->getDbs();
        $methodology = $freelance->getMethodologies();
        $version = $freelance->getVersionControls();

        /** Transformer les get en tableau   */

        $codingLanguagesArray = $codingLanguages->toArray();
        $frameworkArray = $framework->toArray();
        $databaseArray = $database->toArray();
        $methodologyArray = $methodology->toArray();
        $versionArray = $version->toArray();

        $builder
            ->add('coding_language', EntityType::class, [
                'class' => CodingLanguage::class,
                'required'=>false,
                'multiple' => true,
                'choice_label' => 'name_coding_language',
                'preferred_choices' => function ($choice, $key, $value) use ($codingLanguagesArray) {
                    return in_array($choice, $codingLanguagesArray);
                },
            ])
            ->add('framework', EntityType::class, [
                'class' => Framework::class,
                'required'=>false,
                'multiple' => true,
                'choice_label' => 'name_framework',
                'preferred_choices' => function ($choice, $key, $value) use ($frameworkArray) {
                    return in_array($choice, $frameworkArray);
                },
            ])
            ->add('database', EntityType::class, [
                'required'=>false,
                'class' => Db::class,
                'multiple' => true,
                'choice_label' => 'name_db',
                'preferred_choices' => function ($choice, $key, $value) use ($databaseArray) {
                    return in_array($choice, $databaseArray);
                },
            ])
            ->add('methodology', EntityType::class, [
                'required'=>false,
                'class' => Methodology::class,
                'multiple' => true,
                'choice_label' => 'name_methodology',
                'preferred_choices' => function ($choice, $key, $value) use ($methodologyArray) {
                    return in_array($choice, $methodologyArray);
                },
            ])
            ->add('version_control', EntityType::class, [
                'required'=>false,
                'class' => VersionControl::class,
                'multiple' => true,
                'choice_label' => 'name_version_control',
                'preferred_choices' => function ($choice, $key, $value) use ($versionArray) {
                    return in_array($choice, $versionArray);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'freelance' => null
        ]);
    }
}
