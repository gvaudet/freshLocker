<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom*',
                'attr' => [
                    'placeholder' => 'Nom',
                    ],
                ])
            ->add('firstname', TextType::class, [
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
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de mobile*',
                'attr' => [
                    'placeholder' => '+33...',
                    ],
                ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'En cochant cette case, j’accepte les CGV/CGU... blabla RGPD',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez cocher la case '
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire', 
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // Enlever la vérification navigateur pour la partie développement :
            // 'attr' => [
            //     'novalidate' => 'novalidate' 
            // ]
        ]);
    }
}
