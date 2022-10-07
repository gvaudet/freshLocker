<?php

namespace App\Controller;

use App\Entity\User;
use App\Classes\Mail;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function signin(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository): Response
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

            $mail = new Mail(); 

            $content = 'Bonjour'.' '.$user->getFirstname()."<br/>Bienvenue dans la grande famille FreshLocker"; 

            $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue dans la grande famille FreshLocker', $content);

            // Message flash et redirection
            $this->addFlash('success', 'Compte utilisateur créé !'); // Boucle à faire dans le twig pour affichage
            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Pour accéder à l'utilisateur connecté :
        if ($this->getUser()) {
            return $this->redirectToRoute('main_index');
        }

        // Get the login error if there is one :
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user :
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        // This method can be blank - it will be intercepted by the logout key on your firewall
    }
}
