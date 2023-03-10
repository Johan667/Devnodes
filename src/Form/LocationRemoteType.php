<?php

namespace App\Form;

use App\Entity\Freelance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationRemoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('city', TextType::class, [
                'label' => 'city',
                'attr' => ['id' => 'city'],
            ])
            ->add('remoteWork', ChoiceType::class, [
                'label' => 'Préférence',
                'choices' => [
                    'A distance' => 'A distance',
                    'Sur place' => 'Sur place',
                ]
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
