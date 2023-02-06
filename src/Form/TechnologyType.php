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
        $codingLanguagesArray = $codingLanguages->toArray();

        $builder
            ->add('coding_language', EntityType::class, [
                'class' => CodingLanguage::class,
                'multiple' => true,
                'choice_label' => 'name_coding_language',
                'preferred_choices' => function ($choice, $key, $value) use ($codingLanguagesArray) {
                    return in_array($choice, $codingLanguagesArray);
                },
            ])
            ->add('framework', EntityType::class, [
                'class' => Framework::class,
                'multiple' => true,

                'choice_label' => 'name_framework',
            ])
            ->add('database', EntityType::class, [
                'class' => Db::class,
                'multiple' => true,

                'choice_label' => 'name_db',
            ])
            ->add('methodology', EntityType::class, [
                'class' => Methodology::class,
                'multiple' => true,

                'choice_label' => 'name_methodology',
            ])
            ->add('version_control', EntityType::class, [
                'class' => VersionControl::class,
                'multiple' => true,

                'choice_label' => 'name_version_control',
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
