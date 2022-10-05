<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande', 'order_')]
class OrderController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        if (!$this->getUser()->getAddress()->getValues())
        {
            return $this->redirectToRoute('address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
