<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Livre;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, ['attr' => ['class' => 'form-control form-control-line'],
                                          'label'=> 'Nom'])
            ->add('prenom',TextType::class, ['attr' => ['class' => 'form-control form-control-line'],
                                             'label'=> 'Prénom'])
            ->add('telephone',NumberType::class, ['attr' => ['class' => 'form-control form-control-line'],
                                            'label'=> 'Téléphone'])
          
            ->add('datenaiss', DateType::class, ['widget'=>'single_text', 
                                                 'attr'=> ['class' => 'form_control form-control-line'],
                                                 'label' => 'Date de naissance'])
            ->add('livres', EntityType::class,
            ['attr' => ['class'=> 'form-control form-control-line'],
            'label'=> 'Livre(s)',
            'class' => Livre::class,
            'multiple'=> true,
            'expanded' => false,
            'choice_label' => 'titre',
            'placeholder'=>'selectionner un ou plusieurs livres'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
