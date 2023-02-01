<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'label' => 'Content'
            ])
            ->add('datetime', DateTimeType::class, [
                'label' => 'Date and Time'
            ])
            ->add('sender', EntityType::class, [
                'class' => 'App\Entity\User',
                'choice_label' => 'email',
                'label' => 'Sender'
            ])
            ->add('recipient', EntityType::class, [
                'class' => 'App\Entity\User',
                'choice_label' => 'email',
                'label' => 'Recipient'
            ])
            ->add('mission', EntityType::class, [
                'class' => 'App\Entity\Mission',
                'choice_label' => 'title',
                'label' => 'Mission'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
