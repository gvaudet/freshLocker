<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('', name: 'main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        # Récupération d'une catégorie
        $legume = $categoryRepository->findOneByAlias('legumes');
        $fruit = $categoryRepository->findOneByAlias('fruits');
        return $this->render('main/index.html.twig', [
            'legume' => $legume,
            'fruit' => $fruit,
        ]);    }
}
