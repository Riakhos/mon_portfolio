<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ProjectCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet')
            ->setEntityLabelInPlural('Projets')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des projets')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un projet')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un projet')
            ->setHelp(Crud::PAGE_INDEX, 'Gérez les projets affichés sur votre site.')
            ->setHelp(Crud::PAGE_EDIT, 'Modifiez les informations d\'un projet.')
            ->setHelp(Crud::PAGE_NEW, 'Ajoutez un nouveau projet.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Section: Informations générales
            FormField::addFieldset('Informations générales')->setIcon('fas fa-info-circle'),
            TextField::new('title', 'Titre du projet')
                ->setColumns('col-md-4')
                ->setHelp('Entrez le titre du projet.'),
            IntegerField::new('hoursWorked', 'Heures travaillées')
                ->setColumns('col-md-2')
                ->setHelp('Indiquez le nombre d\'heures travaillées pour ce projet.'),
            TextEditorField::new('description', 'Description du projet')
                ->setColumns('col-md-6')
                ->setHelp('Entrez une description détaillée du projet.'),

            // Section: Liens
            FormField::addFieldset('Liens')->setIcon('fas fa-link'),
            TextField::new('github_link', 'Lien GitHub')
                ->setColumns('col-md-6')
                ->setHelp('Entrez le lien vers le dépôt GitHub du projet.'),
            TextField::new('demo_link', 'Lien de démonstration')
                ->setColumns('col-md-6')
                ->setHelp('Entrez le lien vers la démonstration du projet.'),

            // Section: Image
            FormField::addFieldset('Image')->setIcon('fas fa-image'),
            ImageField::new('image', 'Image du projet')
                ->setBasePath('/uploads/projects')
                ->setUploadDir('public/uploads/projects')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setColumns('col-md-6')
                ->setHelp('Téléchargez une image représentative du projet.'),

            // Section: Compétences, Frameworks et APIs
            FormField::addFieldset('Technologies utilisées')->setIcon('fas fa-tools'),
            ArrayField::new('skills', 'Compétences')
                ->setColumns('col-md-4')
                ->setHelp('Entrez les compétences utilisées dans ce projet sous forme de tableau. Exemple: {"Symfony": 50, "Twig": 20, "PHP": 30}'),
            ArrayField::new('frameworks', 'Frameworks')
                ->setColumns('col-md-4')
                ->setHelp('Entrez les frameworks utilisés dans ce projet sous forme de tableau. Exemple: {"Symfony": 50, "Laravel": 50}'),
            ArrayField::new('apis', 'APIs')
                ->setColumns('col-md-4')
                ->setHelp('Entrez les APIs utilisées dans ce projet sous forme de tableau. Exemple: {"Google Maps": 50, "Stripe": 50}'),

            // Section: Dates
            FormField::addFieldset('Dates')->setIcon('fas fa-calendar-alt'),
            DateField::new('createdAt', 'Date de création')
                ->setColumns('col-md-6')
                ->hideOnForm()
                ->setHelp('Date de création du projet.'),
            DateField::new('updated', 'Date de mise à jour')
                ->setColumns('col-md-6')
                ->hideOnIndex()
                ->setHelp('Date de la dernière mise à jour du projet.'),
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'updateTimestamp',
        ];
    }

    public function updateTimestamp(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Project) {
            $entity->updateTimestamp(); // Met à jour la date de mise à jour
        }
    }
}
