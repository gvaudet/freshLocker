<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\FreshLocker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user']; 

        $builder
            ->add('adresse', EntityType::class, [
                'label' => false, 
                'required' => true,
                'class' => Address::class, 
                'choices' => $user->getAddress(),
                // 'choice_label' => 'fullAddress',
                'multiple' => false, 
                'expanded' => true
            ])

            ->add('freshLocker', EntityType::class, [
                'label' => 'Chosisissez votre FreshLocker', 
                'required' => true,
                'class' => FreshLocker::class, 
                'multiple' => false, 
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider ma commande', 
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
     }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array()
            // Configure your form options here
        ]);
    }
}
