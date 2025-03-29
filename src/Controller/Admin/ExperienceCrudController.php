<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Experience;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Doctrine\ORM\EntityManagerInterface;

class ExperienceCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Experience::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Expérience')
            ->setEntityLabelInPlural('Expériences')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des expériences')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une expérience')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une expérience')
            ->setHelp(Crud::PAGE_INDEX, 'Gérez les expériences affichées sur votre site.')
            ->setHelp(Crud::PAGE_EDIT, 'Modifiez les informations d\'une expérience.')
            ->setHelp(Crud::PAGE_NEW, 'Ajoutez une nouvelle expérience.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addFieldset('Informations Professionnelles')->setIcon('fas fa-briefcase'),
            TextField::new('title', 'Titre de l\'expérience')
                ->setColumns('col-md-6')
                ->setHelp('Entrez le titre de l\'expérience.'),
            TextEditorField::new('description', 'Description de l\'expérience')
                ->setColumns('col-md-6')
                ->setHelp('Entrez une description détaillée de l\'expérience.'),
            TextField::new('titleJob', 'Titre du poste')
                ->setColumns('col-md-6')
                ->setHelp('Entrez le titre du poste.'),
            TextEditorField::new('descriptionJob', 'Description du poste')
                ->setColumns('col-md-6')
                ->setHelp('Entrez une description détaillée du poste.'),
            TextField::new('institution', 'Institution')
                ->setColumns('col-md-6')
                ->hideOnIndex()
                ->setHelp('Entrez le nom de l\'institution.'),
            DateField::new('startDate', 'Date de début')
                ->setColumns('col-md-6')
                ->setHelp('Entrez la date de début de l\'expérience.'),
            DateField::new('endDate', 'Date de fin')
                ->setColumns('col-md-6')
                ->setHelp('Entrez la date de fin de l\'expérience.'),
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'setAbout',
            BeforeEntityUpdatedEvent::class => 'setAbout',
        ];
    }

    public function setAbout($event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Experience)) {
            return;
        }

        $about = $this->em->getRepository(About::class)->findOneBy([]);
        $entity->setAbout($about);
    }
}
