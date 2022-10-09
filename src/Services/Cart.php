<?php 

namespace App\Classes;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart 
{
    public function getCart(SessionInterface $session, ProductRepository $productRepository)
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
    }
}
