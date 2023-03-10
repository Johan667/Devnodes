<?php

namespace App\Form;

use App\Entity\CodingLanguage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

// l'extension permet de faire savoir a Symfony que la class est un formulaire
class SearchForm extends AbstractType
{

    //construction du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => CodingLanguage::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name_coding_language',
                'choice_value' => 'id',
                'placeholder' => 'Choisir une compétence',
            ])
            ->add('city', TextType::class, [
                'required'=>false,
                'label' => false,
                'attr' => ['id' => 'city'],

            ]);
    }

    //configuration du formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET'
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}