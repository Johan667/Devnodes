<?php

namespace App\Form;

use App\Entity\Freelance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FreelanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('denominationCompany')
            ->add('siretCompany')
            ->add('tvaCompany')
            ->add('profilPicture')
            ->add('coverPicture')
            ->add('description')
            ->add('phone')
            ->add('registerDate')
            ->add('title')
            ->add('location')
            ->add('country')
            ->add('address')
            ->add('city')
            ->add('codePostal')
            ->add('price')
            ->add('durationPreference')
            ->add('remoteWork')
            ->add('xpYears')
            ->add('workCategories')
            ->add('spokenLanguages')
            ->add('dbs')
            ->add('platforms')
            ->add('versionControls')
            ->add('frameworks')
            ->add('methodologies')
            ->add('codingLanguages')
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
