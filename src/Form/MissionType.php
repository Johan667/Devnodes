<?php

namespace App\Form;

use App\Entity\Mission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la mission',
                'required' => true,
                    ]
                )
            ->add('frenquency', ChoiceType::class, array(
                'label' => 'Votre projet est urgent ?',
                'choices'  => array(
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ),
            ))
            ->add('description', TextareaType::class)
            ->add('addFile', FileType::class, array(
                'label' => 'Vous pouvez ajouter un fichier -optionnel',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Erreur, veuillez réessayez.',
                        'maxSizeMessage' => 'Erreur, veuillez réessayez.',
                    ])
                ],
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
