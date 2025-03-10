<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm() // Masquer le champ ID dans les formulaires de création et d'édition
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            EmailField::new('email', 'Email')
                ->setHelp('Entrez l\'adresse email de l\'utilisateur.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextField::new('username', 'Pseudo')
                ->setHelp('Entrez le pseudo de l\'utilisateur.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            ArrayField::new('roles', 'Rôles')
                ->setHelp('Définissez les rôles de l\'utilisateur.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            BooleanField::new('isActive', 'Actif')
                ->setHelp('Indique si l\'utilisateur est actif.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            DateTimeField::new('createdAt', 'Date de création')
                ->hideOnForm() // Masquer le champ dans les formulaires de création et d'édition
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage
        ];
    }
}
