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
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class FreelanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Votre adresse email',
                'attr' => [
                    'placeholder' => 'Entrez votre adresse email ici',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'label' => 'Mot de passe',
                'type' => PasswordType::class,
                'mapped' => true,
                'first_options' => ['label' => 'Mot de passe : ', 'attr' => ['class' => 'input-full'], 'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'match' => true,
                        'message' => 'Le mot de passe doit contenir : minimum 8 caractère, un nombre, une minuscule, une majuscule et un caractère spécial',
                    ]),
                ]],

                'second_options' => ['label' => 'Répéter le mot de passe : ', 'attr' => ['class' => 'input-full'], 'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'match' => true,
                        'message' => 'Le mot de passe doit contenir : minimum 8 caractère, un nombre, une minuscule, une majuscule et un caractère spécial',
                    ]),
                ]],
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom ici',
                ],
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre prénom ici',
                ],
            ])
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
            ->add('codingLanguages', EntityType::class, array(
                'label' => 'Quel language de programmation pratiquez-vous ?',
                'class' => CodingLanguage::class,
                'choice_label' => 'name_coding_language',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('dbs',  EntityType::class, array(
                'label' => 'Quel base de données utilisez-vous ?',
                'class' => Db::class,
                'choice_label' => 'name_db',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('frameworks', EntityType::class, array(
                'label' => 'Quel Framework connaissez-vous ?',
                'class' => Framework::class,
                'choice_label' => 'name_framework',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('versionControls', EntityType::class, array(
                'label' => 'Travaillez-vous avec des plate-forme d\'hébergement ?',
                'class' => VersionControl::class,
                'choice_label' => 'name_version_control',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('methodologies', EntityType::class, array(
                'label' => 'Utilisez-vous des méthodes  ?',
                'class' => Methodology::class,
                'choice_label' => 'name_methodology',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('platforms', EntityType::class, array(
                'label' => 'Quelle plateforme utilisez vous ?',
                'class' => Platform::class,
                'choice_label' => 'name_plateform',
                'multiple' => true,
                'expanded' => true,
            ))
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
            ->add('description', TextareaType::class, [
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
            ->add('phone', TelType::class)
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
