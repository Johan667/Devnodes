<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
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
            ->add('denominationCompany', TextType::class, array(
                'label' => 'Nom de votre entreprise -optionnel',
                'required' => false
            ))
            ->add('siretCompany', TextType::class, array(
                'label' => 'Siret de votre entreprise -optionnel',
                'required' => false
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions d\'utilisation du site',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
