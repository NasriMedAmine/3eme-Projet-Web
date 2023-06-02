<?php

namespace App\Form;

use App\Entity\Leader;
use App\Entity\Player;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level')
            ->add('pseudo')
            ->add('password')
            ->add('mail')
            ->add('idPlayer',EntityType::class,[
                'class'=>Player::class,
                'choice_label'=>'Id_Player',
                'multiple'=>false
            ])
            ->add('idUser',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'Id',
                'multiple'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Leader::class,
        ]);
    }
}
