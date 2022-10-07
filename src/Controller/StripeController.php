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
        // Init panier (devrait être un appel d'un service Cart en axe d'amélioration)
        $cart = $session->get('cart');
        $orderId = $session->get('orderId');

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

        // Enregistrer mes produits pour Stripe
        // Axe d'amélioration : création d'une référence de commande en BDD pour faire appel à nos produits sans passer par le panier
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

        // Ajout des frais de livraison au total
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

        // Init Stripe with secret key API Stripe
        Stripe::setApiKey('sk_test_51LpZOgHrQjlZLnq1Oei5S5tTlsNQW6IjMXYYQo6DBpXdLMZ4lkBgXLNG146UWFff8hia6tAMuOTn3HP88htmvDDY00agzchWL1');

        // Création de la session Stripe
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                $products_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci?orderId=' . $orderId,
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur?orderId=' . $orderId,
        ]);

        // Envoyer une réponse Json pour script JS > btn Payer dans Récap de commande
        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}
