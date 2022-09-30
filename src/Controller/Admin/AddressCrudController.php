<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Adresses')
        ->setEntityLabelInSingular('Adresse');

        // ->setPageTitle('admin/', 'FreshLocker - Adminstration des produits');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('number', 'Numéro de rue'),
            TextField::new('streetName', 'Nom de la voie'),
            IntegerField::new('postCode', 'Code postal'),
            TextField::new('city', 'Ville'),
            TextField::new('country', 'Pays'),
        ];
    }
}
