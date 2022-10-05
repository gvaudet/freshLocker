<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/address', name: 'address_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')] // Utilisateur connecté
class AddressController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])] // Affichage des adresses
    public function list(): Response
    {
        $addresses = $this->getUser()->getAddress();

        return $this->render('address/list.html.twig', [
            'addresses' => $addresses
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])] // Créer une adresse
    public function add(Request $request, AddressRepository $addressRepository, SessionInterface $session): Response
    {
        $address = new Address();
        $address->addUser($this->getUser());

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde des données dans la BDD
            $addressRepository->add($address, true);

            // Redirection vers le panier si il y a des artciles 
            if($session->get('cart')){
                return $this->redirectToRoute('cart_index');
            }else{
                // Redirection affichage des adresses
                return $this->redirectToRoute('address_list', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('address/add.html.twig', [
            'address' => $address,
            'form' => $form
        ]);
    }

    #[Route('/{id}/remove', name: 'remove', methods: ['POST'])] // Supprimer une adresse
    public function remove(Request $request, Address $address, AddressRepository $addressRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId($this->getUser()), $request->request->get('_token'))) {
            // Suppression des données dans la BDD
            $addressRepository->remove($address, true);
        }

        return $this->redirectToRoute('address_list', [], Response::HTTP_SEE_OTHER);
    }
}
