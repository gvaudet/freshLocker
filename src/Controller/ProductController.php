<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        
        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/{id}/{label}', name: 'single')]
    public function single($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        return $this->render('product/single.html.twig', [
            'product' => $product
        ]);
    }
}
