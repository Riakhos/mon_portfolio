<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Form\SocialLinkType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('À propos')
            ->setEntityLabelInPlural('À propos')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des informations "À propos"')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les informations "À propos"')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter des informations "À propos"')
            ->setHelp(Crud::PAGE_INDEX, 'Gérez les informations affichées sur la page "À propos" de votre site.')
            ->setHelp(Crud::PAGE_EDIT, 'Modifiez les informations affichées sur la page "À propos" de votre site.')
            ->setHelp(Crud::PAGE_NEW, 'Ajoutez de nouvelles informations pour la page "À propos" de votre site.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addFieldset('Informations Personnelles')->setIcon('fas fa-user'),
            TextField::new('firstname', 'Prénom')->setColumns('col-md-3'),
            TextField::new('lastname', 'Nom')->setColumns('col-md-3'),
            DateField::new('birthdate', 'Date de naissance')->setColumns('col-md-2'),
            TextField::new('birthplace', 'Lieu de naissance')->setColumns('col-md-2'),
            CountryField::new('birthcountry', 'Pays de naissance')->setColumns('col-md-2'),
            TextField::new('email', 'Email')->setColumns('col-md-6'),
            TelephoneField::new('phone', 'Téléphone')->setColumns('col-md-6'),
            TextField::new('zoom', 'Zoom')->setColumns('col-md-6'),
            TextField::new('address', 'Adresse')->setColumns('col-md-6'),
            TextField::new('postal', 'Code postal')->setColumns('col-md-4'),
            TextField::new('city', 'Ville')->setColumns('col-md-4'),
            CountryField::new('country', 'Pays')->setColumns('col-md-4'),

            FormField::addFieldset('Réseaux Sociaux')->setIcon('fas fa-share-alt'),
            CollectionField::new('socialLinks', 'Réseaux sociaux')
                ->setEntryType(SocialLinkType::class)
                ->setFormTypeOption('by_reference', false)
                ->setColumns('col-md-12')
                ->setTemplatePath('admin/social_link_form.html.twig')
                ->hideOnIndex(),

            FormField::addFieldset('Informations Professionnelles')->setIcon('fas fa-briefcase'),
            TextField::new('jobTitle', 'Titre métier')->setColumns('col-md-4'),
            TextEditorField::new('aboutMe', 'À propos de moi')->setColumns('col-md-8'),
        ];
    }
}
