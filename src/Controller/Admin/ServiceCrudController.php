<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un service')
            ->setEntityLabelInPlural('Mes services')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des services')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un service')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un service')
            ->setHelp(Crud::PAGE_INDEX, 'Gérez les services affichés sur votre site.')
            ->setHelp(Crud::PAGE_EDIT, 'Modifiez les informations d\'un service.')
            ->setHelp(Crud::PAGE_NEW, 'Ajoutez un nouveau service.')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $required = true;
        
        if ($pageName == 'edit') {
            $required = false;
        }
        
        return [
            TextField::new('title', 'Titre du service')
                ->setHelp('Titre du service')
                ->setColumns('col-md-3')
                ->setRequired($required)
            ,

            TextField::new('icon', 'Icon du service')
                ->setHelp('Icon du service')
                ->setColumns('col-md-3')
                ->setRequired($required)
            ,

            TextEditorField::new('description', 'Description du service')
                ->setHelp('Description du service')
                ->setColumns('col-md-6')
                ->setRequired($required)
            ,
            
        ];
    }
}
