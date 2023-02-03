<?php
namespace App\Form;

use App\Entity\CodingLanguage;
use App\Entity\Framework;
use App\Entity\Db;
use App\Entity\Methodology;
use App\Entity\VersionControl;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coding_language', EntityType::class, [
                'class' => CodingLanguage::class,
                'choice_label' => 'name_coding_language',
            ])
            ->add('framework', EntityType::class, [
                'class' => Framework::class,
                'choice_label' => 'name_framework',
            ])
            ->add('database', EntityType::class, [
                'class' => Db::class,
                'choice_label' => 'name_db',
            ])
            ->add('methodology', EntityType::class, [
                'class' => Methodology::class,
                'choice_label' => 'name_methodology',
            ])
            ->add('version_control', EntityType::class, [
                'class' => VersionControl::class,
                'choice_label' => 'name_version_control',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
