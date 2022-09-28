<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', null, [
                'label' => 'Nom*',
                'attr' => [
                    'placeholder' => 'Nom',
                    ],
                ])
            ->add('firstname', null, [
                'label' => 'Prénom*',
                'attr' => [
                    'placeholder' => 'Prénom',
                    ],
                ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail*',
                'help' => 'L\'email choisi sera votre identifiant de connexion',
                'attr' => [
                    'placeholder' => 'loremipsum@dolor.com',
                    ],
                ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe*',
                'help' => 'Le mot de passe doit contenir au moins 8 caractères',
                'attr' => [
                    'placeholder' => '********',
                    ],
                ])
            ->add('address', null, [
                'label' => 'Adresse postale*',
                'attr' => [
                    'placeholder' => '88 rue du panier, 59000 Lille',
                    ],
                ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de mobile*',
                'attr' => [
                    'placeholder' => '+33...',
                    ],
                ])
            ->add('isEnabled', CheckboxType::class, [
                'label' => 'En cochant cette case, j’accepte les CGV/CGU... blabla RGPD',
                ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'I know, it\'s silly, but you must agree to our terms.'
            //         ])
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // Enlever la vérification navigateur pour la partie développement :
            // 'attr' => [
            //    'novalidate' => 'novalidate' 
            // ]
        ]);
    }
}
