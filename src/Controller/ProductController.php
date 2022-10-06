<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Déplacement de cette au niveau du else ligne 34 pour éviter trop de code et rassembler le tout dans le if
        // $products = $productRepository->findAll();

        // Nouvelle instance de formulaire de recherche 
        $search =new Search(); 
        // Création du form
        $form = $this->createForm(SearchType::class, $search); 

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Création de la nouvelle méthode findWithSearch() dans le productRepository
            $products = $productRepository->findWithSearch($search);
        }else{
            $products = $productRepository->findAll();
        }

        $products = $paginator->paginate(
        $products, // Requête contenant les données à paginer
        $request->query->getInt('page', 1), // Numéro de la page en cours > passé dans l'URL (1 si aucune page)
        10 // Nombre de résultats par page
    );
        
        return $this->render('product/list.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{alias}', name: 'single')]
    public function single(Product $product = null): Response
    {
        if ($product === null) {
            // Modifier par un message d'erreur en cas de produit non trouvé (ou qui n'existe plus)
            dd('PRODUIT NULL');
        }

        return $this->render('product/single.html.twig', [
            'product' => $product
        ]);
    }
}
