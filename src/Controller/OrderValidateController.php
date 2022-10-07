<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci', name: 'order_validate')]
    public function index(Request $request, SessionInterface $session, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find(
            $request->get('orderId')
        );

        // Sécurité si la commande n'existe pas ou qu'elle n'appartient pas au user connecté :
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('main_index');
        }
        
        // isIsPaid ? Aucun sens, à changer
        if ($order->isIsPaid() == 0) {
            $order->setIsPaid(true);
            $this->entityManager->flush();

            $session->remove('cart');
            $session->remove('orderId');
        }

        // TODO : Envoi de l'email

        return $this->render('order_validate/index.html.twig', [
            'order' => $order
        ]);
    }
}