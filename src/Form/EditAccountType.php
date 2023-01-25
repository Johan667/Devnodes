<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('email',EmailType::class, array(
                'required' => false
            ))
            ->add('firstname',TextType::class, array(
                'required' => false
            ))
            ->add('lastname',TextType::class, array(
                'required' => false
            ))
            ->add('denominationCompany',TextType::class, array(
                'required' => false
            ))
            ->add('siretCompany',TextType::class, array(
                'required' => false
            ))
            ->add('tvaCompany',TextType::class, array(
                'required' => false
            ))
            ->add('phone',TelType::class, array(
                'required' => false
            ))
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
