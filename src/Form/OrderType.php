<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user']; 

        // $builder
    //         ->add('adresses', EntityType::class, [
    //             'label' => 'Chosisissez votre adresses de livraison', 
    //             'required' => true,
    //             'class' => Address::class, 
    //             'choices' => $user->getAddresses(),
    //             'multiple' => false, 
    //             'expanded' => true
    //         ])
    //     ;
     }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array()
            // Configure your form options here
        ]);
    }
}
