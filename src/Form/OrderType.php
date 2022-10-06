<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\FreshLocker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                'expanded' => true,
                'constraints' => array(
                    new NotBlank([
                        'message' => 'Veuillez choisir une adresse de facturation'
                    ])
               )
            ])

            ->add('freshLocker', EntityType::class, [
                'label' => 'Choisissez votre FreshLocker', 
                'required' => true,
                'class' => FreshLocker::class, 
                'multiple' => false, 
                'expanded' => true,
                'constraints' => array(
                    new NotBlank([
                        'message' => 'Veuillez choisir un FreshLocker'
                    ])
               )
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
            'user' => array(),
            // Enlever la vérification navigateur pour la partie développement :
            'attr' => [
               'novalidate' => 'novalidate' 
            ]            
        ]);
    }
}
