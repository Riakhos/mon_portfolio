<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResumeCrudController extends AbstractCrudController implements EventSubscriberInterface
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
            TextField::new('title', 'Titre de l\'expérience')->setColumns('col-md-6'),
            TextEditorField::new('description', 'Description de l\'expérience')->setColumns('col-md-6'),
            TextField::new('titleJob', 'Titre du poste')->setColumns('col-md-6'),
            TextEditorField::new('descriptionJob', 'Description du poste')->setColumns('col-md-6'),
            TextField::new('institution', 'Institution')->setColumns('col-md-6'),
            DateField::new('startDate', 'Date de début')->setColumns('col-md-3'),
            DateField::new('endDate', 'Date de fin')->setColumns('col-md-3'),
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
