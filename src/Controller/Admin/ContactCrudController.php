<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Contact')
            ->setEntityLabelInPlural('Contacts');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm() // Masquer le champ ID dans les formulaires de création et d'édition
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextField::new('name', 'Nom')
                ->setHelp('Entrez le nom du contact.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextField::new('email', 'Email')
                ->setHelp('Entrez l\'adresse email du contact.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextField::new('subject', 'Sujet')
                ->setHelp('Entrez le sujet du message.')
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage

            TextEditorField::new('message', 'Message')
                ->setHelp('Entrez le message du contact.')
                ->setColumns('col-md-12'), // Définir la colonne pour l'affichage

            DateTimeField::new('sent_at', 'Date d\'envoi')
                ->hideOnForm() // Masquer le champ dans les formulaires de création et d'édition
                ->setColumns('col-md-6'), // Définir la colonne pour l'affichage
        ];
    }
}
