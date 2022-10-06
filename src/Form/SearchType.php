<?php 

namespace App\Form;

use App\Classes\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false, 
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre Recherche ...',
                ]
                ])
            ->add('categories', EntityType::class, [
                'label' => false, 
                'required' => false, 
                'class' => Category::class,
                'multiple' => true, 
                'expanded' => true
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Filtrer', 
                'attr' =>[
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET', 
            // Proposition de désactiver la crsf_protection de symfony mais comme manque d'expérience préférence pour le garder pour le moment avant avis d'expert 
            // 'crsf_protection' => false,
        ]);
    }


    public function getBlockPrefix()
    {
        // Evite de "Poluer" l'URL avec le préfixe comme app_QQCH donc demande à l'app de ne rien return 
        return ''; 
    }
}