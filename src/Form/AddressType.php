<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'label' => 'Numéro'
                ]
            )
            ->add('streetName', null, [
                'label' => 'Nom de voie'
            ])
            ->add('postCode', null, [
                'label' => 'Code postal'
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('country', null, [
                'label' => 'pays'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
