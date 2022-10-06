<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Conditioning;
use App\Entity\FreshLocker;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[Route('/admin')]

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ProductCrudController::class)
            ->generateUrl();

            return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FreshLocker');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('E-commerce');

        yield MenuItem::subMenu('Produits', 'fas fa-apple-whole')->setSubItems([
            MenuItem::linkToCrud('Ajouter un produit', 'fas fa-plus',Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les produits', 'fas fa-eye',Product::class)
        ]);

        yield MenuItem::subMenu('Catégories', 'fas fa-layer-group')->setSubItems([
            MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus',Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye',Category::class)
        ]);

        yield MenuItem::subMenu('Conditionnement', 'fas fa-box-open')->setSubItems([
            MenuItem::linkToCrud('Ajouter un conditionnement', 'fas fa-plus',Conditioning::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les conditionnement', 'fas fa-eye',Conditioning::class)
        ]);

        yield MenuItem::subMenu('Personnes', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Ajouter une personne', 'fas fa-plus',User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les personnes', 'fas fa-eye',User::class)
        ]);

        yield MenuItem::subMenu('Adresses', 'fas fa-home')->setSubItems([
            MenuItem::linkToCrud('Ajouter une adresse', 'fas fa-plus',Address::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les adresses', 'fas fa-eye',Address::class)
        ]);

        yield MenuItem::subMenu('FreshLocker', 'fas fa-table-cells')->setSubItems([
            MenuItem::linkToCrud('Ajouter un FeshLocker', 'fas fa-plus',FreshLocker::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les FreshLocker', 'fas fa-eye',FreshLocker::class)
        ]);
        
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
