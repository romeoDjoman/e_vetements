<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(RequestStack $rs, ProduitRepository $repo): Response
    {
        $session = $rs->getSession();
        $cart = $session->get('cart', []);
        
        //* je vais créer un nouveau tableau qui contiendra des objets Product et les quantité de chaque objet
        $cartWithData = [];
        $total = 0;
        //*Pour chaque $id qui se trouve dans mon tableau $cart, j'ajoute une case au tableau $cartWithData, qui est multidimensionnel
        //* chaque case est elle-même un tableau associatif contenant 2 cases : une case 'product' (produit entier récupéré en BDD) et une case 'quantity' (avec la quantité de se produit présent dans le panier)
        foreach($cart as $id => $quantity)
        {
            $produit = $repo->find($id);
            $cartWithData[] = [
                'produit' => $produit,
                'quantity' => $quantity
            ];
            $total += $produit->getPrix() * $quantity;
        }
        
        
        return $this->render('cart/index.html.twig', [
           'items' => $cartWithData,
           'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, RequestStack $rs)
    {
        //* nous allons récupérer ou créer une session grâce à la classe RequestStack
        $session = $rs->getSession();
        
        $cart = $session->get('cart', []);
        //* je récupère l'attribut de session 'cart' s'il existe ou un tableau vide

        //* si le produit existe deja dans ma cart, j'incrémente sa quantité
        if(!empty($cart[$id]))
        {
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        
        //* dans mon tableau $cart, à la case $id, je donne la valeur 1

        $session->set('cart', $cart);
        //* je sauvegarde l'état de mon panier en session à l'attribut de session 'cart'

        // dd($session->get('cart'));
        return $this->redirectToRoute('app_product');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, RequestStack $rs)
    {
        $session = $rs->getSession();
        $cart = $session->get('cart', []);

        //*si l'id existe dans mon panier, je le supprime du tableau via unset()
        if(!empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');
    }
}
