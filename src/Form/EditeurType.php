<?php

namespace App\Form;

use App\Entity\Editeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class EditeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Nom'])
            ->add('adress',TextType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Adresse'])
            ->add('pays',TextType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Pays'])
            ->add('telephone',NumberType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label'=> 'Téléphone'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Editeur::class,
        ]);
    }
}
