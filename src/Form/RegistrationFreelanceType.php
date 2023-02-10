<?php

namespace App\Form;

use App\Entity\Freelance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Regex;


class RegistrationFreelanceType extends AbstractType
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
            ->add('title', TextType::class, [
                'label' => 'Titre de profil',
                'required' => false,
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
            ->add('xpYears', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Veuillez entrer un chiffre',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Freelance::class,
        ]);
    }
}
