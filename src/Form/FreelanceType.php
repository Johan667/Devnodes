<?php

namespace App\Form;

use App\Entity\CodingLanguage;
use App\Entity\Db;
use App\Entity\Framework;
use App\Entity\Freelance;
use App\Entity\Methodology;
use App\Entity\Platform;
use App\Entity\SpokenLanguage;
use App\Entity\VersionControl;
use App\Entity\WorkCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Regex;

class FreelanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('workCategories', EntityType::class, array(
                'label' => 'Quel est votre métier ?',
                'class' => WorkCategory::class,
                'choice_label' => 'name_category',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('xpYears', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Veuillez entrer un chiffre',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
                'attr' => [
                    'id' => 'city',
                ]])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'required' => false,
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
            ])

            ->add('title', TextType::class, [
                'label' => 'Titre de profil',
                'required' => false,
            ])
            ->add('biographie', TextareaType::class, [
                'label' => 'Description de votre profil',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Entrez votre tarif journalier',
            ])
            ->add('remoteWork', ChoiceType::class, array(
                'label'=> 'Ou aimez-vous travailler ?',
                'choices' => array(
                    'A distance' => 'A distance',
                    'Sur place' => 'Sur place',
                    'Les deux' => 'Les deux',
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('spokenLanguages', EntityType::class, array(
                'class' => SpokenLanguage::class,
                'label' => 'Quel langue parlez-vous ?',
                'choice_label' => 'name_language',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Freelance::class,
        ]);
    }
}
