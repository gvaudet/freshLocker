<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commande', 'order_')]
class OrderController extends AbstractController
{
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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dd($form->getData());
        }
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cartWithDataProduct,
            'total' => $total,
        ]);
    }
}
