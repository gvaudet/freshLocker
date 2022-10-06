<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Produits')
        ->setEntityLabelInSingular('Produit');

        // ->setPageTitle('', 'FreshLocker - Adminstration des produits');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField:: new('label', 'Nom du produit :'),
            SlugField::new('alias')->setTargetFieldName('label'),
            AssociationField::new('producers'),
            AssociationField::new('category'),
            AssociationField::new('conditioning'),
            TextareaField:: new('description', 'Description :'),
            TextField::new('photo', 'chemin de l\'image du produit:'),
            MoneyField::new('unitPrice', 'Prix unitaire')->setCurrency('EUR'), 
            // Alias => Slug

        ];
    }
}
