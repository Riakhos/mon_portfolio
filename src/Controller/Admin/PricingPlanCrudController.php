<?php

namespace App\Controller\Admin;

use App\Entity\PricingPlan;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PricingPlanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PricingPlan::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Plan de Tarification')
            ->setEntityLabelInPlural('Plans de Tarification')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des Plans de Tarification')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un Plan de Tarification')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un Plan de Tarification')
            ->setHelp(Crud::PAGE_INDEX, 'Gérez les plans de tarification affichés sur votre site.')
            ->setHelp(Crud::PAGE_EDIT, 'Modifiez les informations d\'un plan de tarification.')
            ->setHelp(Crud::PAGE_NEW, 'Ajoutez un nouveau plan de tarification.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Informations du Plan')->setIcon('fas fa-info-circle'),
            TextField::new('name', 'Nom du Plan')->setColumns('col-md-4'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR')->setStoredAsCents(false)->setColumns('col-md-4'),
            TextField::new('currency', 'Devise')->setColumns('col-md-4'),

            FormField::addPanel('Détails du Plan')->setIcon('fas fa-list'),
            TextField::new('storage', 'Stockage')->setColumns('col-md-3'),
            TextField::new('projects', 'Projets')->setColumns('col-md-3'),
            TextField::new('domains', 'Domaines')->setColumns('col-md-3'),
            TextField::new('users', 'Utilisateurs')->setColumns('col-md-3'),
        ];
    }
}
