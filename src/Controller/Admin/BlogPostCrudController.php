<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

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
        ->setEntityLabelInPlural('Articles de blog')
        ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des articles de blog')
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un article')
        ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un article')
        ->setHelp(Crud::PAGE_INDEX, 'Gérez les articles affichés sur votre site.')
        ->setHelp(Crud::PAGE_EDIT, 'Modifiez les informations d\'un article.')
        ->setHelp(Crud::PAGE_NEW, 'Ajoutez un nouvel article.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
             // Section: Informations générales
            FormField::addFieldset('Informations générales')->setIcon('fas fa-info-circle'),
            TextField::new('title', 'Titre de l\'article')
                ->setHelp('Entrez le titre de l\'article.')
                ->setColumns('col-md-4'), // Définir la colonne pour l'affichage

            AssociationField::new('author', 'Auteur')
                ->setHelp('Sélectionnez l\'auteur de l\'article.')
                ->setColumns('col-md-4'), // Définir la colonne pour l'affichage

            ChoiceField::new('selectedSocialLinkType', 'Lien social à afficher')
                ->setChoices([
                    'Facebook' => 'facebook',
                    'Twitter' => 'twitter',
                    'LinkedIn' => 'linkedin',
                    'Instagram' => 'instagram',
                    'GitHub' => 'github',
                ])
                ->setHelp('Sélectionnez le type de lien social à afficher pour cet article.')
                ->setColumns('col-md-4'),

            TextEditorField::new('content', 'Contenu')
                ->setHelp('Entrez le contenu de l\'article.')
                ->setColumns('col-md-12'), // Définir la colonne pour l'affichage

            // Section: Image
            FormField::addFieldset('Image')->setIcon('fas fa-image'),
            ImageField::new('image', 'Image du Blog')
                ->setBasePath('/uploads/blogpost')
                ->setUploadDir('public/uploads/blogpost')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setColumns('col-md-6') // Définir la colonne pour l'affichage
                ->setHelp('Image de votre article en 600*600px'),
            
            // Section: Framework et Catégorie
            FormField::addFieldset('Catégorie et Framework')->setIcon('fas fa-tags'),
            ChoiceField::new('framework', 'Framework')
                ->setChoices([
                    'Symfony' => 'Symfony',
                    'Laravel' => 'Laravel',
                    'Django' => 'Django',
                    'Spring' => 'Spring',
                    'React' => 'React',
                    'HTML/CSS' => 'HTML/CSS',
                    'JavaScript' => 'JavaScript',
                    'Vue.js' => 'Vue.js',
                    'Angular' => 'Angular',
                    'Node.js' => 'Node.js',
                    'React Native' => 'React Native',
                    'Bootstrap' => 'Bootstrap',
                    'jQuery' => 'jQuery',
                    'Next.js' => 'Next.js',
                    'REST API' => 'REST API',
                    'Docker' => 'Docker',
                    'Kubernetes' => 'Kubernetes',
                    'GitHub' => 'GitHub',
                    'Trello' => 'Trello',
                    'Figma' => 'Figma',
                    'MongoDB' => 'MongoDB',
                    'Xampp' => 'Xampp',
                    'Stripe' => 'Stripe',
                ])
                ->allowMultipleChoices(true) // Permet plusieurs sélections
                ->setHelp('Sélectionnez le framework utilisé dans ce projet.')
                ->setColumns('col-md-6'),
            
            ChoiceField::new('category', 'Catégorie')
                ->setChoices([
                    'Développement Web' => 'web',
                    'Développement Mobile' => 'mobile',
                    'Développement front-end' => 'front-end',
                    'Développement back-end' => 'back-end',
                    'Développement full-stack' => 'full-stack',
                    'Data Science' => 'data',
                    'DevOps' => 'devops',
                ])
                ->allowMultipleChoices(true) // Permet plusieurs sélections
                ->setHelp('Sélectionnez une catégorie pour cet article.')
                ->setColumns('col-md-6'),

            // Section: Dates
            FormField::addFieldset('Dates')->setIcon('fas fa-calendar-alt'),
            DateTimeField::new('created_at', 'Date de création')
                ->setColumns('col-md-6')
                ->hideOnForm()
                ->setHelp('Date de création de l\'article.'),
            DateTimeField::new('updated', 'Date de mise à jour')
                ->setColumns('col-md-6')
                ->hideOnIndex()
                ->setHelp('Date de la dernière mise à jour de l\'article.'),
        ];
    }
}
