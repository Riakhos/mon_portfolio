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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

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
        $required = true;
        
        if ($pageName == 'edit') {
            $required = false;
        }
        
        return [
            FormField::addFieldset('Informations Personnelles')->setIcon('fas fa-user'),
            TextField::new('firstname', 'Prénom')
                ->setColumns('col-md-3')
                ->setHelp('Entrez votre prénom.'),
            TextField::new('lastname', 'Nom')
                ->setColumns('col-md-3')
                ->setHelp('Entrez votre nom.'),
            DateField::new('birthdate', 'Date de naissance')
                ->setColumns('col-md-2')
                ->setHelp('Entrez votre date de naissance.'),
            TextField::new('birthplace', 'Lieu de naissance')
                ->setColumns('col-md-2')
                ->setHelp('Entrez votre lieu de naissance.'),
            CountryField::new('birthcountry', 'Pays de naissance')
                ->setColumns('col-md-2')
                ->setHelp('Entrez votre pays de naissance.'),
            TextField::new('email', 'Email')
                ->setColumns('col-md-6')
                ->setHelp('Entrez votre adresse email.'),
            TelephoneField::new('phone', 'Téléphone')
                ->setColumns('col-md-6')
                ->setHelp('Entrez votre numéro de téléphone.'),
            TextField::new('zoom', 'Zoom')
                ->setColumns('col-md-6')
                ->setHelp('Entrez votre identifiant Zoom.'),
            TextField::new('address', 'Adresse')
                ->setColumns('col-md-6')
                ->setHelp('Entrez votre adresse.'),
            TextField::new('postal', 'Code postal')
                ->setColumns('col-md-4')
                ->setHelp('Entrez votre code postal.'),
            TextField::new('city', 'Ville')
                ->setColumns('col-md-4')
                ->setHelp('Entrez votre ville.'),
            CountryField::new('country', 'Pays')
                ->setColumns('col-md-4')
                ->setHelp('Entrez votre pays.'),

            FormField::addFieldset('Réseaux Sociaux')->setIcon('fas fa-share-alt'),
            CollectionField::new('socialLinks', 'Réseaux sociaux')
                ->setEntryType(SocialLinkType::class)
                ->setFormTypeOption('by_reference', false)
                ->setColumns('col-md-12')
                ->setTemplatePath('admin/social_link_form.html.twig')
                ->hideOnIndex()
                ->setHelp('Ajoutez vos liens vers les réseaux sociaux.'),

            FormField::addFieldset('Informations Professionnelles')->setIcon('fas fa-briefcase'),
            ImageField::new('imageHeader', 'Image de couverture')
                ->setHelp('Image de votre entête de page')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath('/uploads/imageHeader')
                ->setUploadDir('public/uploads/imageHeader')
                ->setRequired($required)
                ->hideOnIndex()
                ->setColumns('col-md-6'),
            ImageField::new('imageAvatar', 'Image de profil')
                ->setHelp('Image de votre profil')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath('/uploads/imageAvatar')
                ->setUploadDir('public/uploads/imageAvatar')
                ->setRequired($required)
                ->hideOnIndex()
                ->setColumns('col-md-6'),

            TextField::new('jobTitle', 'Titre métier')
                ->setColumns('col-md-4')
                ->setHelp('Entrez votre titre professionnel.'),
            TextEditorField::new('aboutMe', 'À propos de moi')
                ->setColumns('col-md-8')
                ->setHelp('Entrez une description à propos de vous.'),
        ];
    }
}
