<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'legal_')]

class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'ML')]
    public function ML(): Response
    {
        return $this->render('legal/ML.html.twig');
    }

    #[Route('/conditions-generales-de-vente', name: 'CGV')]
    public function CGV(): Response
    {
        return $this->render('legal/CGV.html.twig');
    }

    #[Route('/conditions-generales-dutilisation', name: 'CGU')]
    public function CGU(): Response
    {
        return $this->render('legal/CGU.html.twig');
    }
}
