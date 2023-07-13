<?php

namespace App\Controller\Admin;


use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            // TextField::new('title'),
            // TextEditorField::new('description'),

            AssociationField::new('produit'),
            AssociationField::new('membre'),
            IntegerField::new('quantite')->setNumberFormat(''),
            MoneyField::new('montant')->setCurrency('EUR'),
            ChoiceField::new('etat')->autocomplete()->setChoices(['En cours de livraison' => 'en_cours_de_livraison', 'Envoyé' => 'envoye', 'Livré' => 'Livre']),
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $commande =  new $entityFqcn;
        $commande->setDateEnregistrement(new \Datetime);
        return $commande;
    }
   
}
