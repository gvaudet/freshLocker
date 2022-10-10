<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCanceledController extends AbstractController
{
    #[Route('/commande/erreur', name: 'order_canceled')]
    public function index(Request $request, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find(
            $request->get('orderId')
        );

        // Sécurité si la commande n'existe pas ou qu'elle n'appartient pas au user connecté :
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('main_index');
        }

        // TODO : Envoi de l'email
        $user = $order->getUser();

        $mail = new Mail(); 

        $content = 'Bonjour'.' '.$user->getFirstname()."<br/> Une mauvaise nouvelle !!"; 

        $mail->send($user->getEmail(), $user->getFirstname(), 'Votre paiement à échoué mais nous ne sommes pas contre le fait de recommencer 👀', $content);


        return $this->render('order_canceled/index.html.twig', [
            'order' => $order
        ]);
    }
}
