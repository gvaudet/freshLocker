<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeController extends AbstractController
{
    const DELIVERY_PRICE = 1.99;

    #[Route('/commande/create-session', name: 'stripe_create_session')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {   
        // Init panier
        $cart = $session->get('cart'); 

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

        // Init products for stripe
        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://localhost:8080';

        // Enregistrer mes produits Orderline()
        foreach ($cartWithDataProduct as $product) {
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getUnitPrice() * 100,
                    'product_data' => [
                        'name' => $product['product']->getLabel(),
                    ],
                ],
                'quantity' => $product['quantity'],
            ];
        }

        // Ajout des frais de livraison
        $products_for_stripe[] = [  
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => self::DELIVERY_PRICE * 100,
                'product_data' => [
                    'name' => 'Frais de Livraison',
                ],
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('sk_test_51LpZOgHrQjlZLnq1Oei5S5tTlsNQW6IjMXYYQo6DBpXdLMZ4lkBgXLNG146UWFff8hia6tAMuOTn3HP88htmvDDY00agzchWL1');

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                $products_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;

        // return $this->redirect($checkout_session->url));
    }
}
