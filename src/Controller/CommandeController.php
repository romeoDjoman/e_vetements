<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function AfficheCommande(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_product');
        }

        $commande = new Commande(); 
        
        // Récupérer les informations du panier depuis la requête
        $cart = $request->get('cart', []);

        $commande = new Commande();
        $commande->setQuantite($cart[]);
        $commande->setMontant($cart[]);
        $commande->setEtat('Nouvelle');
        $commande->setDateEnregistrement(new \DateTime());
        // Assurez-vous de définir le membre et le produit associés à la commande en fonction de votre logique d'application.
        
        // Enregistrer la commande dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();
        
        // Rediriger l'utilisateur vers la page de gestion des commandes
        return $this->redirectToRoute('gestion_commandes');
    }

        public function gestionCommandes(): Response
    {
        // Récupérer toutes les commandes depuis la base de données
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();
        
        // Afficher la page de gestion des commandes avec les commandes récupérées
        return $this->render('commande/gestion_commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
