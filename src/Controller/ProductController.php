<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll();

        return $this->render('product/index.html.twig', [
            'produits' => $produits
        ]);
    }
}
