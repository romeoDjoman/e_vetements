<?php

namespace App\Controller\Admin;

use Datetime;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->HideOnForm(),
            // TextField::new('title'),
            // TextEditorField::new('description'),

            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            ImageField::new('photo')->setBasePath('assets/uploads')->setUploadDir('public/assets/uploads')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]'),
            TextField::new('description'),
            ChoiceField::new('couleur')->autocomplete()->setChoices(['Rouge' => 'Rouge', 'Jaune' => 'Jaune', 'Bleu' => 'Bleu', 'Vert' => 'Vert']),
            ChoiceField::new('taille')->autocomplete()->setChoices(['L' => 'Large', 'M' => 'Medium', 'S' => 'Small']),
            MoneyField::new('prix')->setCurrency('EUR'),
            IntegerField::new('stock', 'stock'),
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm(),
            ChoiceField::new('collection')->autocomplete()->setChoices(['Automne' => 'Automne', 'Eté' => 'Eté', 'Hiver' => 'Hiver', 'Printemps' => 'Printemps', 'Toute saison' => 'touteSaison']),
        
        ];

    }

    public function createEntity(string $entityFqcn)
    {
        $produit =  new $entityFqcn;
        $produit->setDateEnregistrement(new Datetime);
        return $produit;
    }
    
   
}
