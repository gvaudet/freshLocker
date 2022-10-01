<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'cart_')]

class CartController extends AbstractController
{
    // public function __construct(private SessionInterface $session)
    // {
    // }

    #[Route('', name: 'index')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
    $cart = $session->get('cart', []);

    $cartWithDataProduct = [];
    
    foreach($cart as $id => $quantity){
        $cartWithDataProduct[] =[
            'product' => $productRepository->find($id), 
            'quantity' => $quantity
        ];
        
    }

    $total = 0; 
    
    foreach($cartWithDataProduct as $item){
        $totalItem = $item['product']->getunitPrice() * $item['quantity'];
        $total += $totalItem;
    }

        return $this->render('/cart/index.html.twig', [
            'items' => $cartWithDataProduct,
            'total' => $total,
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add($id, SessionInterface $session)
    {        
        $cart = $session->get('cart', []); 
        
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove($id, SessionInterface $session){
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}
