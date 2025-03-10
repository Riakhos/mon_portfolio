<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet')
            ->setEntityLabelInPlural('Projets');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre')
                ->setHelp('Entrez le titre du projet.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextareaField::new('description', 'Description')
                ->setHelp('Entrez la description du projet.')
                ->setColumns('col-md-12'), // Définir la colonne pour l'affichage

            ImageField::new('image')
                ->setLabel('Image')
                ->setHelp('Image de votre produit en 600*600px')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath('/uploads')
                ->setUploadDir('public/uploads')
                ->setRequired(false)
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            UrlField::new('github_link', 'Lien GitHub')
                ->setHelp('Entrez le lien GitHub du projet.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            UrlField::new('demo_link', 'Lien Démo')
                ->setHelp('Entrez le lien de la démo du projet.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            DateTimeField::new('created_at', 'Date de création')
                ->hideOnForm() // Masquer le champ dans les formulaires de création et d'édition
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            DateTimeField::new('updated', 'Date de mise à jour')
                ->hideOnIndex() // Masquer le champ dans la vue index
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage
        ];
    }
}
