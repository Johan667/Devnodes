<?php

namespace App\Form;

use App\Entity\Freelance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('denominationCompany', TextType::class)
            ->add('siretCompany', TextType::class)
            ->add('tvaCompany', TextType::class)
            ->add('profilPicture', FileType::class)
            ->add('coverPicture', FileType::class)
            ->add('description', TextareaType::class)
            ->add('phone', TelType::class)
            ->add('registerDate', DateType::class)
            ->add('title', TextType::class)
            ->add('location', TextType::class)
            ->add('country', CountryType::class)
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('price', NumberType::class)
            ->add('durationPreference', ChoiceType::class, array(
                'choices' => array(
                    'Half Day' => 'Half Day',
                    'Full Day' => 'Full Day',
                    'Week' => 'Week',
                    'Month' => 'Month',
                )
            ))
            ->add('remoteWork', ChoiceType::class, array(
                'choices' => array(
                    'Yes' => true,
                    'No' => false,
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('xpYears', NumberType::class)
            ->add('workCategories', EntityType::class, array(
                'class' => 'App\Entity\WorkCategory',
                'choice_label' => 'name_category',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('spokenLanguages', TextType::class)
            ->add('dbs', TextType::class)
            ->add('platforms', TextType::class)
            ->add('versionControls', TextType::class)
            ->add('frameworks', TextType::class)
            ->add('methodologies', TextType::class)
            ->add('codingLanguages', TextType::class)
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
