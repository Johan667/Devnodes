<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'Votre adresse email',
                'attr' => [
                    'placeholder' => 'Entrez votre adresse email ici',
                ],
            ])
            ->add('firstname', TextType::class, [
                'required' => false,
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom ici',
                ],
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
