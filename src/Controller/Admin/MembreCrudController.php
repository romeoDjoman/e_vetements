<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreCrudController extends AbstractCrudController
{
    public function __construct(public UserPasswordHasherInterface $hasher)
    {

    }

    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            /* IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'), */

            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom'),
            ChoiceField::new('civilite')->autocomplete()->setChoices(['Homme' => 'H', 'Femme' => 'F']),
            TextField::new('pseudo', 'Pseudo'),
            TextField::new('password', 'Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            CollectionField::new('roles')->setTemplatePath('/admin/fields/roles.html.twig'),  
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    
    {
        if(!$entityInstance->getId()) 
        // Fait référence à l'entitté en cours
        {
            $entityInstance->setDateEnregistrement(
                new \Datetime 
            );

            $entityInstance->setPassword(
                $this->hasher->hashPassword(
                    $entityInstance, $entityInstance->getPassword()
                )
                );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
   
}

