<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderLine;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commande', 'order_')]
class OrderController extends AbstractController
{

    const DELIVERY_PRICE = 1.99;

    #[Route('', name: 'index')]
    public function index(SessionInterface $session, ProductRepository $productRepository, Request $request): Response
    {

        // Voir pour refaire le service pour alleger le Controller  
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

        if (!$this->getUser()->getAddress()->getValues())
        {
            return $this->redirectToRoute('address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);


        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cartWithDataProduct,
            'total' => $total,
        ]);
    }

    #[Route('/recapitulatif', name: 'recap', methods: ['POST'])]
    public function add(SessionInterface $session, ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        // Voir pour refaire le service pour alleger le Controller  
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

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);

        // "??coute" de la requete
        $form->handleRequest($request);
        // D??claration des frais de livraison

        if ($form->isSubmitted() && $form->isValid()){
            // D??claration des variables 
            $date = new \DateTime();
            $freshLocker = $form->get('freshLocker')->getData();
            $freshLocker_content = $freshLocker->getName().' '.$freshLocker->getAddress();
            $address = $form->get('adresse')->getData();
            $address_content = $address->getNumber().' '.$address->getStreetName().' '.$address->getPostCode().' '.$address->getCity().' '.$address->getCountry();

            // Enregistrer ma commande Order()
            $order = new Order(); 
            $order->setUser($this->getUser()); 
            $order->setOrderDate($date); 
            $order->setBillingAddress($address_content);
            $order->setFreshLocker($freshLocker_content);
            $order->setIsPaid(0);
            $order->setTotalPrice($total);

            $entityManager->persist($order); 

            // Enregistrer mes produits Orderline()
            foreach ($cartWithDataProduct as $product) {
                $orderLine = new OrderLine(); 
                $orderLine->setOrder($order); 
                $orderLine->setProduct($product['product']);
                $orderLine->setProductLabel($product['product']->getLabel());
                $orderLine->setQuantity($product['quantity']);
                $orderLine->setUnitPrice($product['product']->getUnitPrice());
                $orderLine->setTotal($product['product']->getUnitPrice() * $product['quantity']);
                $entityManager->persist($orderLine); 
            }
            
            // Pouss??e (flush) en BDD
            $entityManager->flush();

            // Sauvegarder  en session l'Order ID
            $session->set('orderId', $order->getId());

            // Par "s??curit??" si la personne entre l'url mais n'a pas indiqu?? adresse et freshlocker, elle ne pourra pas afficher cette page 
        }

        return $this->render('order/add.html.twig', [
            'cart' => $cartWithDataProduct,
            'total' => $total,
            'deliveryPrice' => self::DELIVERY_PRICE,
            'billingAddress' => $address_content, 
            'freshLocker' => $freshLocker,
        ]);    
    }
}
