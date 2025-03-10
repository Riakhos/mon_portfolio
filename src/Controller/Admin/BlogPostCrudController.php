<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class BlogPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article de blog')
            ->setEntityLabelInPlural('Articles de blog');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre')
                ->setHelp('Entrez le titre de l\'article.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextareaField::new('content', 'Contenu')
                ->setHelp('Entrez le contenu de l\'article.')
                ->setColumns('col-md-12'), // Définir la colonne pour l'affichage

            ImageField::new('image')
                ->setLabel('Image')
                ->setHelp('Image de votre article en 600*600px')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath('/uploads')
                ->setUploadDir('public/uploads')
                ->setRequired(false)
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            DateTimeField::new('created_at', 'Date de création')
                ->hideOnForm() // Masquer le champ dans les formulaires de création et d'édition
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage
        ];
    }
}
