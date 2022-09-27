<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register')]
    public function signIn(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Hashage du mot de passe
            $hashed = $hasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashed);

            // Sauvegarde des données
            $userRepository->add($user, true);

            // Message flash et redirection
            $this->addFlash('success', 'Compte utilisateur créé !'); // Boucle à faire dans le twig pour affichage
            return $this->redirectToRoute('main_index');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
