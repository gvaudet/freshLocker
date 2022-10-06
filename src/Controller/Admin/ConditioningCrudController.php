<?php

namespace App\Controller\Admin;

use App\Entity\Conditioning;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConditioningCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conditioning::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label', 'Type de conditionnement'),
            NumberField::new('conversionFactor', 'Facteur de conversion')->setNumDecimals(2),
        ];
    }
}
