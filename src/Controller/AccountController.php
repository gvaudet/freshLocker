<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account', name: 'account_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')] // Utilisateur connecté
class AccountController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        $addresses = $this->getUser()->getAddress();

        return $this->render('account/index.html.twig', [
            'addresses' => $addresses
        ]);
    }
}
