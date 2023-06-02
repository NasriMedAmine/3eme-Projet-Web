<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamName')
            ->add('nbPlayers')
        
            ->add('favoriteGames', TextareaType::class, array(
                
                'attr' => array('style' => 'width: 200px' ,'height:200px')
               ))
            ->add('teamDesciption', TextareaType::class, array(
                
                'attr' => array('style' => 'width: 200px' ,'height:200px')
               ))
            ->add('password')
            ->add('teamMail')
           ->add('imageFile',VichImageType::class,[
                'download_label'=>'...',
                
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
