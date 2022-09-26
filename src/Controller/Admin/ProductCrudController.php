<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField:: new('name', 'Nom du produit :'),
            TextareaField:: new('description', 'Description :'),
            TextField::new('photo', 'chemin de l\'image du produit:'),
            MoneyField::new('unitPrice', 'Prix unitaire')->setCurrency('EUR'),
            TextField::new('conversionFactor', 'Facteur de conversion')
        ];
    }
}
