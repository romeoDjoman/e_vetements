<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function AfficheCommande(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_product');
        }

        $commande = new Commande(); 
        



        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    $
    
}
