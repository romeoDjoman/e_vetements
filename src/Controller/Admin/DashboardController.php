<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use App\Entity\Produit;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProduitCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(ProduitCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Vet.com');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Compte');

        yield MenuItem::subMenu('Profil', 'fa-solid fa-user')->setSubItems([
            MenuItem::linkToCrud('S\'inscrire', 'fas fa-plus', Membre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir un membre', 'fas fa-eye', Membre::class)
        ]);

        yield MenuItem::section('Actions');

        yield MenuItem::subMenu('Produits', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter un produit', 'fas fa-plus', Produit::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir un produit', 'fas fa-eye', Produit::class)
        ]);

        yield MenuItem::subMenu('Commandes', 'fas fa-truck-fast')->setSubItems([
            MenuItem::linkToCrud('Ajouter une commande', 'fas fa-plus', Commande::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir une commande', 'fas fa-eye', Commande::class)
        ]);

    }
}
