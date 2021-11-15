<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Auteur;
 

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Titre'])
            ->add('isbn',NumberType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'ISBN'])
            ->add('prix',NumberType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Prix'])
            ->add('qteStock',NumberType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Quantité en Stock'])
            ->add('dateEdition', DateType::class, ['widget'=>'single_text', 
                                                   'attr'=> ['class' => 'form_control form-control-line'],
                                                   'label' => 'Date Edition'])
            ->add(
                'categorie', EntityType::class, [
                'attr' => ['class'=> 'form-control form-control-line'],
                'label' => 'Catégorie',
                'class'=> Categorie::class,
                'choice_label' => 'nom',
                'placeholder'=>'selectionner une categorie',]     
           
                )
            /*->add('categorie')*/

            ->add('auteurs',EntityType::class, [
                'attr' => ['class'=> 'form-control form-control-line'],
                'label'=> 'Auteur(s)',
                'class' => Auteur::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => function ($auteur) {
                    return $auteur->getPrenom()." ".$auteur->getNom();
                }
            ]
                ) 
            ->add('editeur', EntityType::class,
                            ['attr' => ['class'=> 'form-control form-control-line'],
                            'label'=> 'Editeur',
                            'class' => Editeur::class,
                            'multiple'=> false,
                            'expanded' => false,
                            'choice_label' => 'nom',
                            'placeholder'=>'selectionner un éditeur'
                            ])      
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
