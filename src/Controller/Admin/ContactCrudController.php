<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactCrudController extends AbstractCrudController
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'sendResponseEmail',
        ];
    }

    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Message')
        ->setEntityLabelInPlural('Messages')
        ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des messages')
        ->setPageTitle(Crud::PAGE_EDIT, 'Répondre à un message')
        ->setHelp(Crud::PAGE_INDEX, 'Gérez les messages envoyés depuis le formulaire de contact.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Section: Informations sur l'expéditeur
            FormField::addFieldset('Informations sur l\'expéditeur')->setIcon('fas fa-user'),
            TextField::new('name', 'Nom')
                ->setColumns('col-md-6')
                ->setHelp('Nom de l\'expéditeur.')
                ->setDisabled(true), // Champ non modifiable
            TextField::new('email', 'Email')
                ->setColumns('col-md-6')
                ->setHelp('Adresse email de l\'expéditeur.')
                ->setDisabled(true), // Champ non modifiable

            // Section: Détails du message
            FormField::addFieldset('Détails du message')->setIcon('fas fa-envelope'),
            TextField::new('subject', 'Sujet')
                ->setColumns('col-md-6')
                ->setHelp('Sujet du message.')
                ->setDisabled(true), // Champ non modifiable
            TextEditorField::new('message', 'Message')
                ->setColumns('col-md-12')
                ->setHelp('Contenu du message.')
                ->setDisabled(true), // Champ non modifiable
            DateField::new('sentAt', 'Date d\'envoi')
                ->setColumns('col-md-6')
                ->setHelp('Date d\'envoi du message.')
                ->setDisabled(true), // Champ non modifiable

            // Section: Réponse
            FormField::addFieldset('Réponse')->setIcon('fas fa-reply'),
            TextEditorField::new('response', 'Réponse')
                ->setColumns('col-md-12')
                ->setHelp('Entrez votre réponse au message.'),
        ];
    }

    public function sendResponseEmail(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Contact || empty($entity->getResponse())) {
            return;
        }

        $email = (new Email())
            ->from('noreply@monportfolio.com') // Adresse de l'expéditeur
            ->to($entity->getEmail()) // Adresse de l'expéditeur
            ->subject('Réponse à votre message : ' . $entity->getSubject())
            ->text($entity->getResponse());

        $this->mailer->send($email);
    }
}
