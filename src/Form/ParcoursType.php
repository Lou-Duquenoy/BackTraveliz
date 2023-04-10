<?php

namespace App\Form;

use App\Entity\Parcours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('destination')
            ->add('origin')
            ->add('gare_depart')
            ->add('gare_arrivee')
            ->add('aeroport_depart')
            ->add('aeroport_arrivee')
            ->add('terminal')
            ->add('checkin_time')
            ->add('date_depart')
            ->add('date_arrivee')
            ->add('date_retour')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parcours::class,
        ]);
    }
}
