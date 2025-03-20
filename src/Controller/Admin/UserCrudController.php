<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

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
            FormField::addFieldset('Informations Personnelles')->setIcon('fas fa-user'),
            EmailField::new('email', 'Email')
                ->setHelp('Entrez l\'adresse email de l\'utilisateur.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextField::new('username', 'Pseudo')
                ->setHelp('Entrez le pseudo de l\'utilisateur.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            DateField::new('lastLoginAt', 'Dernière connexion')
                ->onlyOnIndex(),

            ChoiceField::new('roles', 'Permissions')
                ->setHelp('Vous pouvez choisir le rôle de cet utilisateur.')
                ->setChoices([
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN'
                ])
                ->allowMultipleChoices(),

            BooleanField::new('isActive', 'Actif')
                ->setHelp('Indique si l\'utilisateur est actif.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            DateTimeField::new('createdAt', 'Date de création')
                ->onlyOnIndex(), // Masquer le champ dans les formulaires de création et d'édition
        ];
    }
}
